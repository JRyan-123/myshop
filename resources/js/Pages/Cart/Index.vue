<script setup>
import { ref, computed } from 'vue'
import { Head, Link, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import OrderSummary from '@/Components/Cart/OrderSummary.vue';
import { formatPrice } from '@/utils/FormatPrice';



defineOptions({
    layout: AppLayout,
});
const props = defineProps({
    cart: Object,
    summary: Object,
});

const cartItems = computed(() =>
    props.cart?.data?.cartItems ?? []
)
const increaseQty = (item) => {
    router.patch(
        route('cart-items.update', item.id),
        {
            quantity: item.quantity + 1
        }
    )
}
const decrementQty = (item) => {
    if (item.quantity > 1) {
        router.patch(
            route('cart-items.update', item.id),
            {
                'quantity': item.quantity - 1
            }
        )
    }
    else {
        removeItem(item)
    }
}

const removeItem = (item) => {
    router.delete(
        route('cart-items.destroy', {
            cart_item: item.id,
        }),
    )
}

const stockRule = (item) => {
    if (item.quantity > item.stock) {
        router.patch(
            route('cart-items.update', item.id),
            {
                quantity: item.stock
            }
        )
        return item.stock
    }
    return item.quantity
}
</script>

<template>

    <Head title="Cart" />

    <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
        <section class="mx-auto max-w-6xl px-6 py-12">
            <div class="mb-8">
                <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
                    Your bag
                </p>
                <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">Cart</h1>
            </div>



            <!-- cart items -->
            <div v-if="cartItems.length" class="grid gap-10 lg:grid-cols-3">
                <!-- Cart items -->
                <ul class="divide-y divide-black/10 lg:col-span-2">
                    <li v-for="item in cartItems" :key="item.id" class="flex gap-4 py-6 first:pt-0">
                        <Link :href="route('products.show', item.product_id)"
                            class="relative h-24 w-16 shrink-0 overflow-hidden rounded-lg shadow-sm">
                            <img :src="`/${item.image_path}`" class="absolute inset-0 h-full w-full object-cover"
                                alt="" />

                            <!-- Dark overlay -->
                            <div class="absolute inset-0 bg-black/40"></div>

                            <!-- Centered text -->
                            <span
                                class="relative z-10 flex h-full items-center justify-center p-2 text-center font-serif text-xs font-semibold leading-snug text-white">
                                {{ item.title }}
                            </span>
                        </Link>

                        <div class="flex flex-1 flex-col justify-between">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <Link :href="route('products.show', item.product_id)"
                                        class="font-serif text-base font-semibold">
                                        {{ item.title }}
                                    </Link>
                                    <p class="text-sm text-[#1B1B1F]/60">{{ item.author }}</p>

                                </div>
                                <button @click="removeItem(item)"
                                    class="text-sm text-[#1B1B1F]/40 transition hover:text-[#8C3B3B]"
                                    aria-label="Remove item">
                                    Remove
                                </button>
                            </div>

                            <div class="mt-4 flex items-center justify-between">

                                <div class="flex items-center gap-3 rounded-full border border-[#1B1B1F]/20 px-2 py-1">
                                    <button @click="decrementQty(item)"
                                        class="flex h-6 w-6 items-center justify-center rounded-full text-sm transition hover:bg-[#1B1B1F]/10"
                                        aria-label="Decrease quantity">
                                        −
                                    </button>
                                    <span class="w-4 text-center text-sm">{{  stockRule(item) }}</span>
                                    <button :disabled="item.quantity >= item.stock" @click="increaseQty(item)"
                                        class="flex h-6 w-6 items-center justify-center rounded-full text-sm transition hover:bg-[#1B1B1F]/10"
                                        aria-label="Increase quantity">
                                        {{ item.quantity >= item.stock ? '' : '+' }}
                                    </button>

                                </div>
                                <span class="text-xs text-[#1B1B1F]/60">stock: {{ item.stock }} </span>
                                <span class="font-medium">{{ formatPrice(item.price * item.quantity) }}</span>
                            </div>
                        </div>
                    </li>
                </ul>

                <!-- Order summary -->
                <OrderSummary :subtotal="props.summary?.subtotal" :shipping_fee="props.summary?.shipping_fee"
                    :total="props.summary?.total">
                    <template #forButtons>
                        <Link :href="route('checkout.index')"
                            class="flex w-full items-center justify-center bg-[#1B1B1F] mt-5 py-3 rounded-full text-[#F7F2E7] text-sm font-medium hover:bg-[#B08D57]">
                            Proceed to Checkout
                        </Link>

                        <Link :href="route('products.index')"
                            class="mt-5 block text-center text-sm font-medium text-[#1B1B1F]/60 hover:text-[#B08D57]">
                            Continue shopping
                        </Link>

                    </template>

                </OrderSummary>
            </div>

            <!-- Empty state -->
            <div v-else class="flex flex-col items-center py-24 text-center">
                <p class="font-serif text-xl font-semibold">Your cart is empty</p>
                <p class="mt-2 text-sm text-[#1B1B1F]/60">Browse the shelf and find something to read.</p>
                <Link :href="route('products.index')"
                    class="mt-6 rounded-full bg-[#1B1B1F] px-6 py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
                    Browse books
                </Link>
            </div>
        </section>
    </div>
</template>
