<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, computed } from 'vue'


defineOptions({
    layout: AdminLayout
})
// In your real app this comes from a paginated Inertia prop, e.g.
// defineProps({ orders: Object }) // Laravel paginator
const orders = ref([
  { id: 1042, customer: 'Juan Dela Cruz', date: 'Aug 15, 2026', payment: 'GCash', total: 535, status: 'Delivered' },
  { id: 1039, customer: 'Maria Santos', date: 'Aug 10, 2026', payment: 'Card', total: 1600, status: 'Shipped' },
  { id: 1031, customer: 'Ramon Reyes', date: 'Aug 3, 2026', payment: 'GCash', total: 4500, status: 'Processing' },
  { id: 1020, customer: 'Ella Cruz', date: 'Jul 28, 2026', payment: 'COD', total: 1375, status: 'Cancelled' },
  { id: 1017, customer: 'Nico Aquino', date: 'Jul 22, 2026', payment: 'Card', total: 890, status: 'Delivered' },
  { id: 1012, customer: 'Bea Fernandez', date: 'Jul 19, 2026', payment: 'GCash', total: 320, status: 'Pending' },
])

const search = ref('')
const statusFilter = ref('All')
const statuses = ['All', 'Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled']

const filteredOrders = computed(() =>
  orders.value.filter((o) => {
    const matchesSearch =
      o.customer.toLowerCase().includes(search.value.toLowerCase()) ||
      String(o.id).includes(search.value)
    const matchesStatus = statusFilter.value === 'All' || o.status === statusFilter.value
    return matchesSearch && matchesStatus
  })
)

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

function updateStatus(order, newStatus) {
  // Replace with router.patch(`/admin/orders/${order.id}`, { status: newStatus })
  order.status = newStatus
}
</script>

<template>

    <template >
      <h1 class="font-serif text-lg font-semibold">Orders</h1>
    </template>

    <!-- Toolbar -->
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
      <div class="flex flex-wrap items-center gap-3">
        <input
          v-model="search"
          type="text"
          placeholder="Search order # or customer..."
          class="w-56 rounded-lg border border-black/10 bg-white px-4 py-2 text-sm outline-none transition focus:border-[#B08D57]"
        />
        <select
          v-model="statusFilter"
          class="rounded-lg border border-black/10 bg-white px-3 py-2 text-sm outline-none transition focus:border-[#B08D57]"
        >
          <option v-for="s in statuses" :key="s" :value="s">{{ s }}</option>
        </select>
      </div>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-2xl border border-black/10 bg-white">
      <table class="w-full text-left text-sm">
        <thead class="border-b border-black/10 bg-black/[0.02]">
          <tr class="text-xs uppercase tracking-wide text-[#1B1B1F]/50">
            <th class="px-5 py-3 font-medium">Order</th>
            <th class="px-5 py-3 font-medium">Customer</th>
            <th class="px-5 py-3 font-medium">Date</th>
            <th class="px-5 py-3 font-medium">Payment</th>
            <th class="px-5 py-3 font-medium">Total</th>
            <th class="px-5 py-3 font-medium">Status</th>
            <th class="px-5 py-3 font-medium text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
          <tr v-for="order in filteredOrders" :key="order.id">
            <td class="px-5 py-3 font-medium">#{{ order.id }}</td>
            <td class="px-5 py-3 text-[#1B1B1F]/70">{{ order.customer }}</td>
            <td class="px-5 py-3 text-[#1B1B1F]/70">{{ order.date }}</td>
            <td class="px-5 py-3 text-[#1B1B1F]/70">{{ order.payment }}</td>
            <td class="px-5 py-3">{{ formatPeso(order.total) }}</td>
            <td class="px-5 py-3">
              <select
                :value="order.status"
                @change="updateStatus(order, $event.target.value)"
                class="rounded-full border-0 px-2.5 py-1 text-xs font-medium outline-none"
                :class="statusStyles[order.status]"
              >
                <option v-for="s in statuses.slice(1)" :key="s" :value="s">{{ s }}</option>
              </select>
            </td>
            <td class="px-5 py-3">
              <div class="flex justify-end">
                <a
                  :href="`/admin/orders/${order.id}`"
                  class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]"
                >
                  View
                </a>
              </div>
            </td>
          </tr>

          <tr v-if="!filteredOrders.length">
            <td colspan="7" class="px-5 py-10 text-center text-sm text-[#1B1B1F]/50">
              No orders match your search.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <p class="mt-4 text-sm text-[#1B1B1F]/50">
      Showing {{ filteredOrders.length }} of {{ orders.length }} orders
    </p>

</template>
