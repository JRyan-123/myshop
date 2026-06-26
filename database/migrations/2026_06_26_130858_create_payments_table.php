<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('paymongo_checkout_session_id');
            $table->string('paymongo_payment_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('PHP');
            $table->enum('payment_method_type', [
                'gcash',
                'card',
                'grab_pay',
                'paymaya'
            ]);
            $table->enum('status', [
                'pending',
                'paid',
                'failed',
                'refunded'
            ])->default('pending');

            $table->json('raw_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
