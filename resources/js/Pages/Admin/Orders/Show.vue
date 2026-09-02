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
    order: Object,
    statuses : Object

})

const order = props.order.data
const selectedStatus = ref(order.status.value)

const saveStatus = () => {

    router.patch(
        route('admin.orders.update', order.id),{
            status: selectedStatus.value,
        },
        {
            preserveState: false,
            preserveScroll: true,
        }
    )

}


</script>

<template>



    <a href="/admin/orders" class="text-sm font-medium text-[#1B1B1F]/60 hover:text-[#B08D57]">
        ← Back to orders
    </a>

    <div class="mt-4 mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-[#1B1B1F]/60">Placed on {{ order.date }}</p>
        <span class="rounded-full px-3 py-1 text-xs font-medium"    >
            <!-- {{ order.paymentStatus }} · {{ order.payment }} -->
        </span>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Left: customer, shipping, items -->
        <div class="space-y-6 lg:col-span-2">
            <div class="rounded-2xl border border-black/10 bg-white p-6">
                <h2 class="font-serif text-base font-semibold">Customer</h2>
                <dl class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-[#1B1B1F]/60">Name</dt>
                        <dd>{{ order.shipping_address.name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-[#1B1B1F]/60">Phone</dt>
                        <dd>{{ order.shipping_address.phone }}</dd>
                    </div>
                    <div class="flex justify-between gap-6 text-right">
                        <dt class="shrink-0 text-[#1B1B1F]/60">Shipping address</dt>
                        <dd>{{ order.shipping_address.city + " " + order.shipping_address.street }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl border border-black/10 bg-white p-6">
                <h2 class="font-serif text-base font-semibold">Items</h2>
                <ul class="mt-4 divide-y divide-black/5">
                    <li v-for="item in order.order_items" :key="item.id"
                        class="flex items-center gap-4 py-4 first:pt-0">
                        <div class="relative h-16 w-12 shrink-0 overflow-hidden rounded-lg shadow-sm">
                            <img :src="`/${item.image_path}`" class="absolute inset-0 h-full w-full object-cover"
                                alt="" />
                        </div>
                        <div class="flex flex-1 items-center justify-between text-sm">
                            <div>
                                <p class="font-medium">{{ item.title }}</p>
                                <p class="text-[#1B1B1F]/60">Qty {{ item.quantity }} · {{ formatPrice(item.price) }}
                                    each
                                </p>
                            </div>
                            <span>{{ formatPrice(item.price * item.quantity) }}</span>
                        </div>
                    </li>
                </ul>

                <dl class="mt-4 space-y-2 border-t border-black/10 pt-4 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-[#1B1B1F]/60">Subtotal</dt>
                        <dd>{{ formatPrice(order.subtotal) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-[#1B1B1F]/60">Shipping</dt>
                        <dd>{{ order.shipping_fee === 0 ? 'Free' : formatPrice(order.shipping_fee) }} </dd>
                    </div>
                    <div class="flex justify-between border-t border-black/10 pt-3 text-base font-semibold">
                        <dt>Total</dt>
                        <dd>{{ formatPrice(order.total) }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Right: status control -->
        <aside class="h-fit space-y-6">
            <div class="rounded-2xl border border-black/10 bg-white p-6">
                <h2 class="font-serif text-base font-semibold">Order status</h2>
                <span class="mt-3 inline-block rounded-full px-3 py-1 text-xs font-medium"
                    :class="statusStyles[order.status.value]">
                    {{ order.status.label }}
                </span>

                <label class="mt-4 block text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">
                    Update status
                </label>
                <select v-model="selectedStatus"
                    class="mt-2 w-full rounded-lg border border-black/10 bg-white px-3 py-2 text-sm outline-none transition focus:border-[#B08D57]">
                    <option :value="order.status.value" disabled hidden>{{ order.status.label }}</option>
                    <option v-for="s in order.status.transitions" :key="s.value" :value="s.value">{{ s.label }}</option>
                </select>

                <button @click="saveStatus"
                    class="mt-4 w-full rounded-full bg-[#1B1B1F] py-2.5 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
                    Save status
                </button>
            </div>

            <div class="rounded-2xl border border-black/10 bg-white p-6">
                <h2 class="font-serif text-base font-semibold">Notes</h2>
                <textarea rows="4" placeholder="Internal note (not visible to customer)..."
                    class="mt-3 w-full rounded-lg border border-black/10 bg-white px-3 py-2 text-sm outline-none transition focus:border-[#B08D57]" />
                <button
                    class="mt-3 w-full rounded-full border border-black/10 py-2 text-sm font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]">
                    Save note
                </button>
            </div>
        </aside>
    </div>
</template>
