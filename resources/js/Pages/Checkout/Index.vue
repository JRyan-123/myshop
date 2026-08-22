<script setup>
import OrderSummary from '@/Components/Cart/OrderSummary.vue'
import { formatPrice } from '@/utils/FormatPrice'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { toast, Toaster } from 'vue-sonner'
import 'vue-sonner/style.css'

const props = defineProps({
    cart: Object,
    summary: Object
})

const cartItems = computed(() =>
    props.cart?.data?.cartItems ?? []
)


const form = useForm({
    name: '',
    phone: '',
    street: '',
    barangay: '',
    city: '',

})


const paymentMethods = [
    { id: 'gcash', label: 'GCash', color: 'bg-[#0072CE]', initials: 'GC' },
    { id: 'paymaya', label: 'PayMaya', color: 'bg-[#2CB34A]', initials: 'PM' },
    { id: 'cod', label: 'Cash on Delivery', color: 'bg-[#B08D57]', initials: '₱' },
]


function submitOrder() {
    form.post(route('orders.store'), {
        onSuccess: () => toast.success('Order placed successfully!'),
        onError: () => toast.error('Unable to place order.'),
    })
}
</script>

<template>
    <Toaster position="top-right" />
    <Head title="Checkout" />

    <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">

        <section class="mx-auto max-w-6xl px-6 py-12">
            <Link :href="route('orders.index')" class="text-sm font-medium text-[#1B1B1F]/60 hover:text-[#B08D57]">
                ← Back to orders
            </Link>
            <div class="mb-8 mt-5">
                <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
                    Almost there
                </p>
                <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">Checkout</h1>
            </div>

            <form @submit.prevent="submitOrder" class="grid gap-10 lg:grid-cols-3">
                <!-- Left: shipping + payment -->
                <div class="space-y-6 lg:col-span-2">
                    <!-- Shipping information -->
                    <div class="rounded-2xl border border-black/10 bg-white/50 p-6">
                        <h2 class="font-serif text-lg font-semibold">Shipping information</h2>
                        <div class="mt-4 space-y-4">

                            <input v-model="form.name" type="text" placeholder="Name" required
                                class="w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]" />

                            <input v-model="form.phone" type="tel" placeholder="Phone" required
                                class="w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]" />

                            <input v-model="form.street" type="text" placeholder="House No. / Street" required
                                class="w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]" />

                            <input v-model="form.barangay" type="text" placeholder="Barangay" required
                                class="w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]" />

                            <input v-model="form.city" type="text" placeholder="City / Municipality" required
                                class="w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]" />

                        </div>
                    </div>

                    <!-- Payment method -->
                    <div class="rounded-2xl border border-black/10 bg-white/50 p-6">
                        <h2 class="font-serif text-lg font-semibold">Payment method</h2>
                        <div class="mt-4 grid grid-cols-3 gap-3">
                            <label v-for="method in paymentMethods" :key="method.id"
                                class="relative flex cursor-pointer flex-col items-center gap-2 rounded-xl border-2 bg-white p-4 text-center transition"
                                :class="form.selectedPayment === method.id
                                    ? 'border-[#1B1B1F]'
                                    : 'border-black/10 hover:border-[#B08D57]'
                                    ">
                                <input v-model="form.selectedPayment" type="radio" name="payment" :value="method.id"
                                    class="sr-only" />
                                <span v-if="form.selectedPayment === method.id"
                                    class="absolute right-2 top-2 flex h-4 w-4 items-center justify-center rounded-full bg-[#1B1B1F] text-[10px] text-white">
                                    ✓
                                </span>
                                <span :class="method.color"
                                    class="flex h-12 w-12 items-center justify-center rounded-full text-sm font-semibold text-white">
                                    {{ method.initials }}
                                </span>
                                <span class="text-xs font-medium leading-tight">{{ method.label }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right: order summary -->
                <OrderSummary :subtotal="props.summary?.subtotal" :shipping_fee="props.summary?.shipping_fee"
                    :total="props.summary?.total">
                    <template #forDetails>
                        <ul class="mt-5 space-y-2 text-sm border-b border-black/10 ">
                            <li v-for="item in cartItems" :key="item.id" class="flex justify-between pt-3">
                                <span>{{ item.quantity }} x {{ item.title }}</span>
                                <span>{{ formatPrice(item.price * item.quantity) }}</span>

                            </li>
                        </ul>
                    </template>

                    <template #forButtons>
                        <button type="button" :disabled="form.processing" @click="submitOrder"
                            class="mt-6 w-full rounded-full bg-[#1B1B1F] py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
                            {{
                                form.processing
                                    ? "Processing..."
                                    : "Place Order"
                            }}
                        </button>
                    </template>

                </OrderSummary>
            </form>
        </section>
    </div>
</template>
