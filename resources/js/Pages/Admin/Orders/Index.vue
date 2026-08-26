<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { formatPrice } from '@/utils/FormatPrice'
import { statusStyles } from '@/utils/statusStyles'
import { router } from "@inertiajs/vue3";
import { ref } from 'vue';


defineOptions({
    layout: AdminLayout
})

const props = defineProps({
    orders: Object,
    filters: Object
})

const orders = props.orders.data ?? []
const search = ref(props.filters.search ?? "");

function updateStatus(order, newStatus) {
    // Replace with router.patch(`/admin/orders/${order.id}`, { status: newStatus })
    order.status = newStatus
}

const searchProducts = () => {
    router.get(
        route('admin.orders.index',{
            search: search.value
        })
    )
}

</script>

<template>

    <template>
        <h1 class="font-serif text-lg font-semibold">Orders</h1>
    </template>

    <!-- Toolbar -->
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-3">
            <input v-model="search" type="text" placeholder="Search order # or customer..."
                class="w-56 rounded-lg border border-black/10 bg-white px-4 py-2 text-sm outline-none transition focus:border-[#B08D57]" />

            <button @click="searchProducts" class=" rounded-lg bg-[#1B1B1F] px-4 py-2 text-white text-sm">
                Search
            </button>
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
                <tr v-for="order in orders" :key="order.id">
                    <td class="px-5 py-3 font-medium">#{{ order.id }}</td>
                    <td class="px-5 py-3 text-[#1B1B1F]/70">{{ order.shipping_address.name }}</td>
                    <td class="px-5 py-3 text-[#1B1B1F]/70">{{ order.date }}</td>
                    <td class="px-5 py-3 text-[#1B1B1F]/70">{{ order.payment }}</td>
                    <td class="px-5 py-3">{{ formatPrice(order.total) }}</td>
                    <td class="px-5 py-3">
                        <select :value="order.status.value" @change="updateStatus(order, $event.target.value)"
                            class="rounded-full border-0 px-2.5 py-1 text-xs font-medium outline-none w-full"
                            :class="statusStyles[order.status.value]">
                            <option :value="order.status.value">
                                {{ order.status.label }}

                            </option>

                            <option v-for="status in order.status.transitions" :key="status.value"
                                :value="status.value">
                                {{ status.label }}
                            </option>
                        </select>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex justify-end">
                            <a :href="`/admin/orders/${order.id}`"
                                class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]">
                                View
                            </a>
                        </div>
                    </td>
                </tr>

                <tr v-if="!orders.length">
                    <td colspan="7" class="px-5 py-10 text-center text-sm text-[#1B1B1F]/50">
                        No orders match your search.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <p class="mt-4 text-sm text-[#1B1B1F]/50">
        Showing {{ orders.length }} of {{ orders.length }} orders
    </p>

</template>
