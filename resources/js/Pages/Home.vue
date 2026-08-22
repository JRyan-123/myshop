<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({
    layout: AppLayout
})

import Category from '@/Components/Home/Category.vue';
import FeaturedBooks from '@/Components/Home/FeaturedBooks.vue';
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    featuredBooks: Array,
    categories: Array,
})
console.log(props.featuredBooks);

const shelf = [
    { title: 'The Long Tide', color: 'bg-[#5B7B6E]' },
    { title: 'Paper Moons', color: 'bg-[#B08D57]' },
    { title: 'Marrow & Ink', color: 'bg-[#8C3B3B]' },
    { title: 'Quiet Hours', color: 'bg-[#3B4C63]' },
]

const addToCart = (productId) => {
    router.post(route('carts.store'), {
        product_id: productId,
        quantity: 1,
    }, {
        preserveScroll: true,
        preserveState: true,
    })
}
</script>

<template>
    <Head title="Home"></Head>
    <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
        <!-- Sticky navbar -->


        <!-- Hero -->
        <section class="mx-auto grid max-w-6xl items-center gap-12 px-6 py-16 md:grid-cols-2 md:py-24">
            <div>
                <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
                    A shelf for every reader
                </p>
                <h1 class="mt-4 font-serif text-4xl font-semibold leading-tight sm:text-5xl">
                    Find your next
                    <span class="italic text-[#B08D57]">favorite</span> story.
                </h1>
                <p class="mt-6 max-w-md text-base leading-relaxed text-[#1B1B1F]/70">
                    Thousands of titles, hand-picked collections, and prices that don't
                    make you choose between rent and reading. Browse the shelf, add to
                    cart, checkout in minutes.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="/books"
                        class="rounded-full bg-[#1B1B1F] px-6 py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
                        Browse books
                    </a>
                    <a href="#featured-books"
                        class="rounded-full border border-[#1B1B1F]/20 px-6 py-3 text-sm font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]">
                        See best sellers
                    </a>
                </div>
            </div>



            <!-- Signature element: a tilted bookshelf of spines -->
            <div class="flex h-64 items-end justify-center gap-3 sm:h-80">
                <div v-for="(book, i) in shelf" :key="book.title"
                    :class="[book.color, i % 2 === 0 ? '-rotate-2' : 'rotate-2']"
                    class="flex h-full w-20 items-center justify-center rounded-sm pb-4 shadow-lg sm:w-16"
                    :style="{ height: `${70 + i * 8}%` }">
                    <span
                        class="rotate-90 whitespace-nowrap text-xs font-serif font-medium tracking-wide text-white/90">
                        {{ book.title }}
                    </span>
                </div>
            </div>
        </section>



        <!-- Category -->
        <Category :categories="categories" />



        <!-- Featured Books -->
        <FeaturedBooks :featuredBooks="featuredBooks">
            <button @click="addToCart(book)"
                class="rounded-full border border-[#1B1B1F]/20 px-3 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:bg-[#B08D57] hover:text-white">
                Add to cart
            </button>
        </FeaturedBooks>
    </div>
</template>
