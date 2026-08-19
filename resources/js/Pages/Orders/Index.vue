<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';


defineOptions({
    layout: AppLayout,
})

const props = defineProps({
    orders: Object
})


// In your real app this would come from a paginated Inertia prop, e.g.
// defineProps({ orders: Object }) // Laravel paginator
const orders = props.orders;

console.log(orders);

const statusStyles = {
  Pending: 'bg-[#B08D57]/15 text-[#B08D57]',
  Processing: 'bg-[#3B4C63]/15 text-[#3B4C63]',
  Shipped: 'bg-[#5B7B6E]/15 text-[#5B7B6E]',
  Delivered: 'bg-[#2F4538]/15 text-[#2F4538]',
  Cancelled: 'bg-[#8C3B3B]/15 text-[#8C3B3B]',
}

function formatPeso(amount) {
  return `₱${amount.toLocaleString('en-PH')}`
}
</script>

<template>
  <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
    <section class="mx-auto max-w-4xl px-6 py-12">
      <div class="mb-8">
        <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
          Your account
        </p>
        <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">Orders</h1>
      </div>

      <ul v-if="orders" class="space-y-4">
        <li
          v-for="order in orders"
          :key="order.id"
          class="rounded-2xl border border-black/10 bg-white/50 p-5 transition hover:border-[#B08D57]"
        >
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
              <p class="font-serif text-base font-semibold">Order #{{ order.id }}</p>
              <p class="text-sm text-[#1B1B1F]/60">{{ order.date }}</p>
            </div>

            <span
              class="rounded-full px-3 py-1 text-xs font-medium"
              :class="statusStyles[order.status]"
            >
              {{ order.status }}
            </span>
          </div>

          <p class="mt-3 text-sm text-[#1B1B1F]/70">
            {{ order.order_items.map(item => item.product_name).join(', ') }}
          </p>

          <div class="mt-4 flex items-center justify-between border-t border-black/10 pt-4">
            <span class="font-medium">{{ formatPeso(order.total) }}</span>
            <a
              :href="`/orders/${order.id}`"
              class="rounded-full border border-[#1B1B1F]/20 px-4 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:bg-[#B08D57] hover:text-white"
            >
              View order
            </a>
          </div>
        </li>
      </ul>

      <!-- Empty state -->
      <div v-else class="flex flex-col items-center py-24 text-center">
        <p class="font-serif text-xl font-semibold">No orders yet</p>
        <p class="mt-2 text-sm text-[#1B1B1F]/60">Once you place an order, it'll show up here.</p>
        <a
          href="/books"
          class="mt-6 rounded-full bg-[#1B1B1F] px-6 py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]"
        >
          Browse books
        </a>
      </div>
    </section>
  </div>
</template>
