<script setup>
import { Link, router } from '@inertiajs/vue3';


const props = defineProps({
    featuredBooks: Object,
});

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
    <section class="mx-auto max-w-6xl px-6 py-16 scroll-mt-20" id="featured-books">
        <div class="mb-10 flex items-end justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
                    Hand-picked this week
                </p>
                <h2 class="mt-2 font-serif text-3xl font-semibold">Featured books</h2>
            </div>
            <Link :href="route('products.index')" class="hidden text-sm font-medium hover:text-[#B08D57] sm:block">
                View all →
            </Link>
        </div>

        <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4">
            <article v-for="book in featuredBooks" :key="book.title" class="group flex flex-col">
                <!-- Book cover -->
                <Link :href="route('products.show', book)"
                    class="group relative block aspect-[3/4] overflow-hidden rounded-xl shadow-sm transition hover:shadow-lg">
                    <!-- Book cover -->
                    <img :src="`/storage/${book.image_path}`" :alt="book.title"
                        class="h-full w-full object-cover transition group-hover:scale-105" />

                    <!-- Dark overlay -->
                    <div class="absolute inset-0 bg-black/40"></div>

                    <!-- Title -->
                    <span
                        class="absolute inset-0 flex items-center justify-center p-3 text-center font-serif text-3xl font-semibold leading-snug text-white">
                        {{ book.title }}
                    </span>
                </Link>

                <div class="mt-3">
                    <Link :href="route('products.show', book.id)" class="font-serif text-base font-semibold">{{ book.title }}</Link>
                    <p class="text-sm text-[#1B1B1F]/60">{{ book.author }}</p>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="font-medium">${{ book.price }}</span>
                        <button @click="addToCart(book.id)"
                            class="rounded-full border border-[#1B1B1F]/20 px-3 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:bg-[#B08D57] hover:text-white">
                            Add to cart
                        </button>
                    </div>
                </div>
            </article>
        </div>
    </section>
</template>
