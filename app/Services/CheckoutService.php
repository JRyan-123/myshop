<?php

namespace App\Services;

use App\Exceptions\EmptyCartException;
use App\Exceptions\InsufficientStockException;
use App\Interfaces\CartInterface;
use App\Interfaces\CheckoutInterface;
use App\Interfaces\OrderInterface;
use App\Models\Product;

use Illuminate\Support\Facades\DB;

class CheckoutService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CartInterface $cart_interface,
        protected CheckoutInterface $checkout_interface,
        protected OrderInterface $order_interface,
    ) {}


    /**
     * Return order details
     *
     * @param integer $userId
     * @return void
     */
    public function OrderSummary(int $userId)
    {
        $cart = $this->cart_interface->getCart($userId);

        if (!$cart) {
           $summary = $this->noCart();
        }else {
            $summary = $this->checkout_interface->calculateSummary($cart);
        }

        return [
            'cart' => $cart,
            'summary' => $summary,
        ];
    }


    /**
     * Subtitute value if found no cart
     *
     * @return void
     */
    public function noCart()
    {
        return [
            'subtotal' => 0,
            'shipping_fee' => 0,
            'total' => 0,
        ];
    }

    public function checkout($userId, $data)
    {
         return DB::transaction(function () use ($userId, $data) {


            // get cart
            $cart = $this->cart_interface->getCart($userId);

            if (!$cart || $cart->cartItems->isEmpty()) {
                throw new EmptyCartException();
            }


            // order details
            $summary = $this->checkout_interface->calculateSummary($cart);



            // create order
            $order = $this->order_interface->createOrder([
                'user_id'           => $userId,
                'order_number'      => $this->generateOrderNumber(),
                'subtotal'          => $summary['subtotal'],
                'shipping_fee'      => $summary['shipping_fee'],
                'total'             => $summary['total'],

                'shipping_address' => [
                    'name'      => $data['name'],
                    'phone'     => $data['phone'],
                    'city'      => $data['city'],
                    'barangay'  => $data['barangay'],
                    'street'    => $data['street'],
                ],
            ]);

            // create order items
            foreach ($cart->cartItems as $cartItem) {

                $product = Product::whereKey($cartItem->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($product->stock < $cartItem->quantity) {
                    throw new InsufficientStockException();
                }

                $this->order_interface->createOrderItem($order, [
                    'product_id'        => $product->id,
                    'product_name'      => $product->title,
                    'price'             => $product->price,
                    'quantity'          => $cartItem->quantity,
                    'subtotal'          => $product->price * $cartItem->quantity,
                ]);

                // deduct cart items quantity to product stock and make inactive when 0 stock
                $product->stock -= $cartItem->quantity;

                if ($product->stock === 0) {
                    $product->is_active = false;
                }

                $product->save();
            }

            // delete cart
            $this->cart_interface->clearCart($cart);

            return $order;
        });
    }
    /**
     * random order number
     *
     * @return string
     */
    protected function generateOrderNumber()
    {
        return 'ORD-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);
    }
}
