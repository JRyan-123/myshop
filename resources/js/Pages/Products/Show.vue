<script setup>
import Flashtoast from '@/Components/Layout/Flashtoast.vue'
import { formatPrice } from '@/utils/FormatPrice'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'


const props = defineProps({
    product: Object,
    recommendedProducts: Object,
})
const book = props.product.data
const related = props.recommendedProducts
console.log(related)

const qty = ref(1)
function decrement() {
    if (qty.value > 1) qty.value--
}
function increment() {
    if (qty.value < book.stock) qty.value++
}

const lineTotal = computed(() => (book.price * qty.value))

const addToCart = (productId, quantity) => {
    router.post(route('carts.store'), {
        product_id: productId,
        quantity: quantity,
    })

    qty.value = 1
}
</script>

<template>
    <Flashtoast />
    <Head title="Details"></Head>
    <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
        <section class="mx-auto max-w-5xl px-6 py-12">
            <!-- Breadcrumb -->
            <Link :href="route('products.index')" class="text-sm font-medium text-[#1B1B1F]/60 hover:text-[#B08D57]">
                ← Back to books
            </Link>

            <div class="mt-6 grid gap-10 md:grid-cols-2">
                <!-- Cover -->
                <div class="flex aspect-[3/4] w-full items-center justify-center rounded-2xl p-10 shadow-sm">
                    <!-- Book cover -->
                    <div
                        class="group relative block aspect-[3/4] overflow-hidden rounded-xl shadow-sm transition hover:shadow-lg">
                        <!-- Book cover -->
                        <img :src="`/${book.image_path}`" :alt="book.title"
                            class="h-full w-full object-cover transition group-hover:scale-105" />

                        <!-- Dark overlay -->
                        <div class="absolute inset-0 bg-black/40"></div>

                        <!-- Title -->
                        <span
                            class="absolute inset-0 flex items-center justify-center p-3 text-center font-serif text-3xl font-semibold leading-snug text-white">
                            {{ book.title }}
                        </span>
                    </div>
                </div>

                <!-- Details -->
                <div>
                    <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
                        {{ book.category.name }}
                    </p>
                    <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">{{ book.title }}</h1>
                    <p class="mt-1 text-[#1B1B1F]/60">by {{ book.author }}</p>


                    <p class="mt-6 text-2xl font-semibold">{{ formatPrice(book.price) }}</p>
                    <p class="mt-1 text-sm" :class="book.stock > 0 ? 'text-[#5B7B6E]' : 'text-[#8C3B3B]'">
                        {{ book.stock > 0 ? `${book.stock} in stock` : 'Out of stock' }}
                    </p>

                    <p class="mt-6 leading-relaxed text-[#1B1B1F]/70">
                        {{ book.description }}
                    </p>

                    <!-- Quantity + add to cart -->
                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <div class="flex items-center gap-3 rounded-full border border-[#1B1B1F]/20 px-2 py-1">
                            <button @click="decrement"
                                class="flex h-8 w-8 items-center justify-center rounded-full text-sm transition hover:bg-[#1B1B1F]/10"
                                aria-label="Decrease quantity">
                                −
                            </button>
                            <span class="w-6 text-center text-sm">{{ qty }}</span>
                            <button :disabled="qty >= book.stock" @click="increment"
                                class="flex h-8 w-8 items-center justify-center rounded-full text-sm transition hover:bg-[#1B1B1F]/10"
                                aria-label="Increase quantity">
                                {{ qty >= book.stock ? '' : '+' }}
                            </button>
                        </div>

                        <button @click="addToCart(book.id, qty)"
                            class="flex-1 rounded-full bg-[#1B1B1F] px-6 py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57] disabled:cursor-not-allowed disabled:opacity-40"
                            :disabled="book.stock === 0">
                            Add to cart — {{ formatPrice(lineTotal) }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Related books -->
            <div class="mt-16">
                <h2 class="font-serif text-xl font-semibold">You might also like</h2>
                <div class="mt-6 grid grid-cols-2 gap-6 sm:grid-cols-3">
                    <div v-for="book in related" :key="book.id" class="group flex flex-col">
                        <Link :href="route('products.show', book)"
                            class="group relative block aspect-[3/4] overflow-hidden rounded-xl shadow-sm transition hover:shadow-lg">
                            <!-- Book cover -->
                            <img :src="`/${book.image_path}`" :alt="book.title"
                                class="h-full w-full object-cover transition group-hover:scale-105" />

                            <!-- Dark overlay -->
                            <div class="absolute inset-0 bg-black/40"></div>

                            <!-- Title -->
                            <span
                                class="absolute inset-0 flex items-center justify-center p-3 text-center font-serif text-3xl font-semibold leading-snug text-white">
                                {{ book.title }}
                            </span>
                        </Link>
                        <Link :href="route('products.show', book)" class="mt-2 text-sm font-medium">{{ book.title }}
                        </Link>
                        <p class="text-sm text-[#1B1B1F]/60">${{ book.price }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
