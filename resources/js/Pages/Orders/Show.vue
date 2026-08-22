<script setup>
import OrderSummary from '@/Components/Cart/OrderSummary.vue';
import { formatPrice } from '@/utils/FormatPrice';
import { statusStyles } from '@/utils/statusStyles';
import { Head, Link } from '@inertiajs/vue3'


const props = defineProps({
    order: Object,
})

const order = props.order.data;

const steps = ['Pending', 'Processing', 'Shipped', 'Delivered']
const currentIndex = steps.indexOf(order.status_label)
</script>

<template>
    <Head title="Order"></Head>

    <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
        <section class="mx-auto max-w-4xl px-6 py-12">
            <Link :href="route('orders.index')" class="text-sm font-medium text-[#1B1B1F]/60 hover:text-[#B08D57]">
                ← Back to orders
            </Link>

            <div class="mt-4 mb-8 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
                        Order #{{ order.order_number }}
                    </p>
                    <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">Order details</h1>
                    <p class="mt-1 text-sm text-[#1B1B1F]/60">Placed on {{ order.date }}</p>
                </div>
                <span class="rounded-full px-4 py-1.5 text-sm font-medium" :class="statusStyles[order.status]">
                    {{ order.status_label }}
                </span>
            </div>



            <!-- Status tracker -->
            <div v-if="order.status !== 'Cancelled'" class="mb-10 flex items-center">
                <template v-for="(step, i) in steps" :key="step">
                    <div class="flex flex-col items-center">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-medium" :class="currentIndex >= i
                                ? 'bg-[#1B1B1F] text-[#F7F2E7]'
                                : 'bg-black/10 text-[#1B1B1F]/40'
                            ">
                            {{ i + 1 }}
                        </div>
                        <span class="mt-2 text-xs text-[#1B1B1F]/60">{{ step }}</span>
                    </div>
                    <div v-if="i < steps.length - 1" class="mx-2 h-0.5 flex-1"
                        :class="currentIndex > i ? 'bg-[#1B1B1F]' : 'bg-black/10'" />
                </template>
            </div>



            <div class="grid gap-6 lg:grid-cols-3">

                <!-- Left: shipping + payment -->
                <div class="space-y-6 lg:col-span-2">
                    <div class="rounded-2xl border border-black/10 bg-white/50 p-6">
                        <h2 class="font-serif text-lg font-semibold">Shipping information</h2>
                        <dl class="mt-4 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-[#1B1B1F]/60">Name</dt>
                                <dd>{{ order.details.name }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#1B1B1F]/60">Phone</dt>
                                <dd>{{ order.details.phone }}</dd>
                            </div>
                            <div class="flex justify-between gap-6 text-right">
                                <dt class="shrink-0 text-[#1B1B1F]/60">Address</dt>
                                <dd>{{ [order.details.street, order.details.barangay, order.details.city].join(', ') }}
                                </dd>
                            </div>
                        </dl>
                    </div>


                    <!-- payment method -->
                    <div class="rounded-2xl border border-black/10 bg-white/50 p-6">
                        <h2 class="font-serif text-lg font-semibold">Payment method</h2>
                        <p class="mt-3 text-sm"> order.payment </p>
                    </div>


                    <!-- item details -->
                    <div class="rounded-2xl border border-black/10 bg-white/50 p-6">
                        <h2 class="font-serif text-lg font-semibold">Items</h2>
                        <ul class="mt-4 divide-y divide-black/10">
                            <li v-for="item in order.order_items" :key="item.id"
                                class="flex items-center gap-4 py-4 first:pt-0">
                                <div class="relative h-24 w-16 shrink-0 overflow-hidden rounded-lg shadow-sm">
                                    <img :src="`/${item.image_path}`"
                                        class="absolute inset-0 h-full w-full object-cover" alt="" />

                                    <!-- Dark overlay -->
                                    <div class="absolute inset-0 bg-black/40"></div>

                                    <!-- Centered text -->
                                    <span
                                        class="relative z-10 flex h-full items-center justify-center p-2 text-center font-serif text-xs font-semibold leading-snug text-white">
                                        {{ item.product_name }}
                                    </span>
                                </div>
                                <div class="flex flex-1 items-center justify-between text-sm">
                                    <div>
                                        <p class="font-medium">{{ item.product_name }}</p>
                                        <p class="text-[#1B1B1F]/60">Qty {{ item.quantity }}</p>
                                    </div>
                                    <span>{{ formatPrice(item.price * item.quantity) }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right: order summary -->
                <OrderSummary :subtotal="order.subtotal" :total = "order.total" :shipping_fee="order.shipping_fee">
                </OrderSummary>
            </div>
        </section>
    </div>
</template>
