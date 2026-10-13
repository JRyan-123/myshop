<script setup>
import { formatPrice } from '@/utils/FormatPrice';
import { Link, router } from '@inertiajs/vue3'
import { X } from 'lucide-vue-next';

const props = defineProps({
  order: Object,
})
const order = props.order


function cancelOrder() {
  if (!confirm('Cancel this order? Your items will be released.')) return
  // router.patch(`/orders/${order.id}/cancel`)  → restores stock inside a DB::transaction
  console.log('cancelling order', order.id)
}
</script>

<template>
  <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
    <section class="mx-auto max-w-lg px-6 py-16 text-center">
      <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#8C3B3B] text-3xl text-white">
        ✕
      </div>

      <p class="mt-6 text-sm font-medium uppercase tracking-widest text-[#B08D57]">
        Order #{{ order.id }}
      </p>
      <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">
        Payment not completed
      </h1>
      <p class="mt-3 text-sm leading-relaxed text-[#1B1B1F]/70">
        Your {{ order.payment.payment_method_type }} payment was cancelled or didn't go through, and you
        haven't been charged. Your order is saved — you can try paying again whenever
        you're ready.
      </p>

      <div class="mt-8 rounded-2xl border border-black/10 bg-white/50 p-6 text-left">
        <dl class="space-y-2 text-sm">
          <div class="flex justify-between">
            <dt class="text-[#1B1B1F]/60">Order</dt>
            <dd>#{{ order.id }}</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-[#1B1B1F]/60">Payment method</dt>
            <dd>{{ order.payment.payment_method_type }}</dd>
          </div>
          <div class="flex justify-between border-t border-black/10 pt-3 text-base font-semibold">
            <dt>Amount due</dt>
            <dd>{{ formatPrice(order.total) }}</dd>
          </div>
        </dl>
      </div>

      <div class="mt-8 flex flex-wrap justify-center gap-3">
        <button @click="router.post(route('orders.retry-payment', order.id))"
          class="rounded-full bg-[#1B1B1F] px-6 py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
          Try payment again
        </button>
        <Link :href="route('orders.index')"
          class="rounded-full border border-[#1B1B1F]/20 px-6 py-3 text-sm font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]">
          Orders
        </Link>
      </div>

      <button @click="router.patch(route('orders.cancel', order.id))"
        class="mt-6 inline-flex items-center gap-2 rounded-full border border-[#8C3B3B]/30 bg-transparent px-5 py-2 text-sm font-medium text-[#8C3B3B] transition-all duration-200 hover:border-[#8C3B3B] hover:bg-[#8C3B3B]/5 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8C3B3B]/30 focus-visible:ring-offset-2 focus-visible:ring-offset-[#F7F2E7] active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50">
        <X />
        Cancel this order
      </button>
    </section>
  </div>
</template>