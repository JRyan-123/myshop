<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({
    layout: AdminLayout,
})
// In your real app these come from an Inertia prop, e.g.
// defineProps({ stats: Object, recentOrders: Array, lowStock: Array })
const stats = [
    { label: 'Total sales', value: '₱182,400', change: '+12.4%', up: true },
    { label: 'Orders', value: '312', change: '+5.1%', up: true },
    { label: 'Books listed', value: '3,204', change: '+18', up: true },
    { label: 'Customers', value: '1,540', change: '-1.2%', up: false },
]

const recentOrders = [
    { id: 1042, customer: 'Juan Dela Cruz', total: 535, status: 'Delivered' },
    { id: 1039, customer: 'Maria Santos', total: 1600, status: 'Shipped' },
    { id: 1031, customer: 'Ramon Reyes', total: 4500, status: 'Processing' },
    { id: 1020, customer: 'Ella Cruz', total: 1375, status: 'Cancelled' },
    { id: 1017, customer: 'Nico Aquino', total: 890, status: 'Delivered' },
]

const lowStock = [
    { title: 'Paper Moons', stock: 3 },
    { title: 'Wander Light', stock: 1 },
    { title: 'The Signal Sea', stock: 4 },
]

const statusStyles = {
    Pending: 'bg-[#B08D57]/15 text-[#B08D57]',
    Processing: 'bg-[#3B4C63]/15 text-[#3B4C63]',
    Shipped: 'bg-[#5B7B6E]/15 text-[#5B7B6E]',
    Delivered: 'bg-[#2F4538]/15 text-[#2F4538]',
    Cancelled: 'bg-[#8C3B3B]/15 text-[#8C3B3B]',
}

</script>

<template>


        <!-- Stat cards -->
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div v-for="stat in stats" :key="stat.label" class="rounded-2xl border border-black/10 bg-white p-5">
                <p class="text-sm text-[#1B1B1F]/60">{{ stat.label }}</p>
                <p class="mt-2 font-serif text-2xl font-semibold">{{ stat.value }}</p>
                <p class="mt-1 text-xs font-medium" :class="stat.up ? 'text-[#5B7B6E]' : 'text-[#8C3B3B]'">
                    {{ stat.change }} vs last month
                </p>
            </div>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-3">
            <!-- Recent orders -->
            <div class="rounded-2xl border border-black/10 bg-white p-5 lg:col-span-2">
                <div class="flex items-center justify-between">
                    <h2 class="font-serif text-base font-semibold">Recent orders</h2>
                    <a href="/admin/orders" class="text-sm font-medium text-[#B08D57] hover:underline">
                        View all
                    </a>
                </div>

                <table class="mt-4 w-full text-left text-sm">
                    <thead>
                        <tr class="text-xs uppercase tracking-wide text-[#1B1B1F]/50">
                            <th class="pb-2 font-medium">Order</th>
                            <th class="pb-2 font-medium">Customer</th>
                            <th class="pb-2 font-medium">Total</th>
                            <th class="pb-2 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5">
                        <tr v-for="order in recentOrders" :key="order.id">
                            <td class="py-3 font-medium">#{{ order.id }}</td>
                            <td class="py-3 text-[#1B1B1F]/70">{{ order.customer }}</td>
                            <td class="py-3">₱{{ order.total.toLocaleString('en-PH') }}</td>
                            <td class="py-3">
                                <span class="rounded-full px-2.5 py-1 text-xs font-medium"
                                    :class="statusStyles[order.status]">
                                    {{ order.status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Low stock -->
            <div class="rounded-2xl border border-black/10 bg-white p-5">
                <h2 class="font-serif text-base font-semibold">Low stock</h2>
                <ul class="mt-4 space-y-3">
                    <li v-for="book in lowStock" :key="book.title" class="flex items-center justify-between text-sm">
                        <span>{{ book.title }}</span>
                        <span class="rounded-full bg-[#8C3B3B]/15 px-2.5 py-1 text-xs font-medium text-[#8C3B3B]">
                            {{ book.stock }} left
                        </span>
                    </li>
                </ul>
                <a href="/admin/books"
                    class="mt-4 block text-center text-sm font-medium text-[#B08D57] hover:underline">
                    Manage inventory
                </a>
            </div>
        </div>

</template>
