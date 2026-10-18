<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Paymongo-Signature');
        $secret = config('services.paymongo.webhook_secret');

        // 1. Verify that PayMongo signed this exact request.
        if (!$secret || !$this->isValidSignature($signature, $payload, $secret)) 
        {
            return response()->json([
                'message' => 'Invalid signature.',
            ], 401);
        }

        // 2. Decode the event after verifying its signature.
        $event = json_decode($payload, true);

        if (! is_array($event)) {
            return response()->json([
                'message' => 'Invalid JSON payload.',
            ], 400);
        }

        $attributes = data_get($event, 'data.attributes', []);
        $eventType = $attributes['type'] ?? null;
        $session = $attributes['data'] ?? [];

        // 3. Process only the successful Checkout Session event.
        if ($eventType !== 'checkout_session.payment.paid') {
            return response()->json([
                'message' => 'Event received; no action required.',
            ], 200);
        }

        $sessionId = $session['id'] ?? null;

        if (! $sessionId) {
            return response()->json([
                'message' => 'Checkout Session ID missing.',
            ], 400);
        }

        // 4. Find the Payment record created during checkout.
        $payment = Payment::where(
            'paymongo_checkout_session_id',
            $sessionId
        )->first();

        if (! $payment) {
            Log::warning('PayMongo session not found.', [
                'checkout_session_id' => $sessionId,
            ]);

            // A non-2xx response allows the provider to retry.
            return response()->json([
                'message' => 'Payment record not found.',
            ], 500);
        }

        // 5. Update payment and order atomically.
        DB::transaction(function () use ($payment) {
            $payment = Payment::whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            $order = $payment->order()
                ->lockForUpdate()
                ->firstOrFail();

            // Duplicate delivery must not repeat the transition.
            if ($payment->status === PaymentStatus::Paid) {
                return;
            }

            // Do not overwrite an incompatible order state.
            if ($order->status !== OrderStatus::Pending) {
                Log::warning('Paid event received for non-pending order.', [
                    'order_id' => $order->id,
                    'order_status' => $order->status->value,
                ]);

                return;
            }

            $payment->update([
                'status' => PaymentStatus::Paid,
            ]);

            $order->update([
                'status' => OrderStatus::Paid,
            ]);
        });

        return response()->json([
            'message' => 'Webhook processed.',
        ], 200);
    }

    private function isValidSignature( ?string $header, string $payload, string $secret): bool 
    {
        if (! $header) {
            return false;
        }

        // PayMongo signature headers contain comma-separated fields.
        $parts = [];

        foreach (explode(',', $header) as $part) {
            $pair = explode('=', trim($part), 2);

            if (count($pair) === 2) {
                $parts[$pair[0]] = $pair[1];
            }
        }

        $timestamp = $parts['t'] ?? null;

        // PayMongo uses different signatures for test and live mode.
        $event = json_decode($payload, true);
        $isLive = data_get(
            $event,
            'data.attributes.livemode',
            false
        );

        $providedSignature = $isLive
            ? ($parts['li'] ?? null)
            : ($parts['te'] ?? null);

        if (! $timestamp || ! $providedSignature) {
            return false;
        }

        $signedPayload = $timestamp . '.' . $payload;

        $expectedSignature = hash_hmac(
            'sha256',
            $signedPayload,
            $secret
        );

        return hash_equals(
            $expectedSignature,
            $providedSignature
        );
    }
}
