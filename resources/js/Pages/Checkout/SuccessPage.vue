<script setup>
import { formatPrice } from '@/utils/FormatPrice';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue'

const props = defineProps({
  order: Object
})

const order = props.order

</script>

<template>
  <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
    <section class="mx-auto max-w-lg px-6 py-16 text-center">
      <div
        class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#2F4538] text-3xl text-white"
      >
        ✓
      </div>

      <p class="mt-6 text-sm font-medium uppercase tracking-widest text-[#B08D57]">
        Order #{{ order.id }}
      </p>
      <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">
        Thank you for your order!
      </h1>
      <p class="mt-3 text-sm leading-relaxed text-[#1B1B1F]/70">
        <template v-if="isPaid">
          Your payment was received. We're getting your books ready to ship.
        </template>
        <template v-else>
          We're confirming your payment with {{ order.payment.payment_method_type }}. This usually takes a few
          moments — you'll see the status update on your order page.
        </template>
      </p>

      <!-- Summary -->
      <div class="mt-8 rounded-2xl border border-black/10 bg-white/50 p-6 text-left">
        <h2 class="font-serif text-lg font-semibold">Order summary</h2>

        <ul class="mt-4 space-y-2 text-sm">
          <li v-for="item in order.items" :key="item.id" class="flex justify-between">
            <span>{{ item.title }} × {{ item.qty }}</span>
            <span>{{ formatPrice(item.price * item.qty) }}</span>
          </li>
        </ul>

        <dl class="mt-4 space-y-2 border-t border-black/10 pt-4 text-sm">
          <div class="flex justify-between">
            <dt class="text-[#1B1B1F]/60">Subtotal</dt>
            <dd>{{ formatPrice(order.subtotal) }}</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-[#1B1B1F]/60">Shipping</dt>
            <dd>{{ formatPrice(order.shipping_fee) }}</dd>
          </div>
          <div class="flex justify-between border-t border-black/10 pt-3 text-base font-semibold">
            <dt>Total</dt>
            <dd>{{ formatPrice(order.total) }}</dd>
          </div>
          <div class="flex justify-between pt-1">
            <dt class="text-[#1B1B1F]/60">Payment</dt>
            <dd>
              {{ order.payment.payment_method_type }} ·
              <span :class="isPaid ? 'text-[#2F4538]' : 'text-[#B08D57]'">
                {{ isPaid ? 'Paid' : 'Confirming' }}
              </span>
            </dd>
          </div>
        </dl>
      </div>

      <div class="mt-8 flex flex-wrap justify-center gap-3">
        
        <Link
          :href="route('orders.show', order.id)"
          class="rounded-full bg-[#1B1B1F] px-6 py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]"
        >
          View order
        </Link>
        <Link
          :href="route('products.index')"
          class="rounded-full border border-[#1B1B1F]/20 px-6 py-3 text-sm font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]"
        >
          Continue shopping
        </Link>
      </div>
    </section>
  </div>
</template>