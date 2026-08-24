<script setup>
import DashboardTiles from '@/Components/Admin/DashboardTiles.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { formatPrice } from '@/utils/FormatPrice';
import { statusStyles } from '@/utils/statusStyles';
import { Link } from '@inertiajs/vue3';

defineOptions({
    layout: AdminLayout,
})

const props = defineProps({
    stats: Object,
    orders: Object,
    lowStock: Object
})

console.log(props.orders)

const stats = props.stats ?? {};
const recentOrders = props.orders.data ?? []
const lowStock = props.lowStock.data ?? []

</script>

<template>


    <!-- Stat cards -->
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <!-- sales -->
        <DashboardTiles label="Total Sales" :value="formatPrice(stats.sales.value)"
            :comparison="stats.sales.comparison" />

        <!-- orders -->
        <DashboardTiles label="Orders" :value="stats.orders.value" :comparison="stats.orders.comparison" />

        <!-- books -->
        <DashboardTiles label="Books listed" :value="stats.books.value" :comparison="stats.books.comparison" />

        <!-- users -->
        <DashboardTiles label="Registered Users" :value="stats.users.value" :comparison="stats.users.comparison" />
    </div>


    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <!-- Recent orders -->
        <div class="rounded-2xl border border-black/10 bg-white p-5 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="font-serif text-base font-semibold">Recent orders</h2>
                <Link :href="route('admin.orders.index')" class="text-sm font-medium text-[#B08D57] hover:underline">
                    View all
                </Link>
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
                        <td class="py-3 text-[#1B1B1F]/70">{{ order.shipping_address.name }}</td>
                        <td class="py-3">{{ formatPrice(order.total) }}</td>
                        <td class="py-3">
                            <span class="rounded-full px-2.5 py-1 text-xs font-medium"
                                :class="statusStyles[order.status.value]">
                                {{ order.status.label }}
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
            <Link :href="route('admin.products.index')"
                class="mt-4 block text-center text-sm font-medium text-[#B08D57] hover:underline">
                Manage inventory
            </Link>
        </div>
    </div>

</template>
