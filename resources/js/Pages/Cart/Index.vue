<script setup>
import { ref, computed } from 'vue'
import { router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

defineOptions({
    layout: AppLayout,
});
const props = defineProps({
    cart: Object,
});

console.log(props.cart.data.cartItems[0]);

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
        })
    )
}

const subtotal = computed(() =>
    props.cart.data.cartItems.reduce(
        (sum, item) => sum + (Number(item.price) * item.quantity),
        0
    )
)

const shipping = computed(() => {
    const itemCount = props.cart.data.cartItems.length;

    if (itemCount === 0) return 0

    return 25 + (itemCount * 5)
})

const total = computed(() => subtotal.value + shipping.value)
</script>

<template>
    <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
        <section class="mx-auto max-w-6xl px-6 py-12">
            <div class="mb-8">
                <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
                    Your bag
                </p>
                <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">Cart</h1>
            </div>

            <div v-if="props.cart.data.cartItems.length" class="grid gap-10 lg:grid-cols-3">
                <!-- Cart items -->
                <ul class="divide-y divide-black/10 lg:col-span-2">
                    <li v-for="item in props.cart.data.cartItems" :key="item.id" class="flex gap-4 py-6 first:pt-0">
                        <div class="relative h-24 w-16 shrink-0 overflow-hidden rounded-lg shadow-sm">
                            <img :src="`/${item.image_path}`" class="absolute inset-0 h-full w-full object-cover"
                                alt="" />

                            <!-- Dark overlay -->
                            <div class="absolute inset-0 bg-black/40"></div>

                            <!-- Centered text -->
                            <span
                                class="relative z-10 flex h-full items-center justify-center p-2 text-center font-serif text-xs font-semibold leading-snug text-white">
                                {{ item.title }}
                            </span>
                        </div>

                        <div class="flex flex-1 flex-col justify-between">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="font-serif text-base font-semibold">{{ item.title }}</h3>
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
                                    <span class="w-4 text-center text-sm">{{ item.quantity }}</span>
                                    <button @click="increaseQty(item)"
                                        class="flex h-6 w-6 items-center justify-center rounded-full text-sm transition hover:bg-[#1B1B1F]/10"
                                        aria-label="Increase quantity">
                                        +
                                    </button>
                                </div>
                                <span class="font-medium">₱{{ (item.price * item.quantity).toFixed(2) }}</span>
                            </div>
                        </div>
                    </li>
                </ul>

                <!-- Order summary -->
                <aside class="h-fit rounded-2xl border border-black/10 bg-white/50 p-6">
                    <h2 class="font-serif text-lg font-semibold">Order summary</h2>

                    <dl class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-[#1B1B1F]/60">Subtotal</dt>
                            <dd>₱{{ subtotal.toFixed(2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-[#1B1B1F]/60">Shipping</dt>
                            <dd>₱{{ shipping.toFixed(2) }}</dd>
                        </div>
                        <div class="flex justify-between border-t border-black/10 pt-3 text-base font-semibold">
                            <dt>Total</dt>
                            <dd>₱{{ total.toFixed(2) }}</dd>
                        </div>
                    </dl>

                    <button
                        class="mt-6 w-full rounded-full bg-[#1B1B1F] py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
                        Checkout
                    </button>
                    <a href="/books"
                        class="mt-3 block text-center text-sm font-medium text-[#1B1B1F]/60 hover:text-[#B08D57]">
                        Continue shopping
                    </a>
                </aside>
            </div>

            <!-- Empty state -->
            <div v-else class="flex flex-col items-center py-24 text-center">
                <p class="font-serif text-xl font-semibold">Your cart is empty</p>
                <p class="mt-2 text-sm text-[#1B1B1F]/60">Browse the shelf and find something to read.</p>
                <a href="/books"
                    class="mt-6 rounded-full bg-[#1B1B1F] px-6 py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
                    Browse books
                </a>
            </div>
        </section>
    </div>
</template>
