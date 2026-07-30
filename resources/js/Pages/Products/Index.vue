<script setup>
import { router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object,
});

console.log("Products:", props.products);

const selectCategory = (category) => {
    router.get(
        route("products.index"),
        {
            category: category === "All" ? null : category,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};
</script>

<template>
    <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
        <section class="mx-auto max-w-6xl px-6 py-12">
            <!-- Page header -->
            <div class="mb-8">
                <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
                    The full catalog
                </p>

                <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">
                    All books
                </h1>
            </div>

            <!-- Category filter -->
            <div class="mb-8 flex flex-wrap gap-2">
                <!-- All category -->
                <button @click="selectCategory('All')"
                    class="rounded-full border px-4 py-2 text-sm font-medium transition" :class="!filters.category
                            ? 'border-[#1B1B1F] bg-[#1B1B1F] text-[#F7F2E7]'
                            : 'border-[#1B1B1F]/20 hover:border-[#B08D57] hover:text-[#B08D57]'
                        ">
                    All
                </button>

                <!-- Database categories -->
                <button v-for="cat in categories" :key="cat.id" @click="selectCategory(cat.slug)"
                    class="rounded-full border px-4 py-2 text-sm font-medium transition" :class="filters.category === cat.slug
                            ? 'border-[#1B1B1F] bg-[#1B1B1F] text-[#F7F2E7]'
                            : 'border-[#1B1B1F]/20 hover:border-[#B08D57] hover:text-[#B08D57]'
                        ">
                    {{ cat.name }}
                </button>
            </div>

            <!-- Product count -->
            <p class="mb-6 text-sm text-[#1B1B1F]/60">
                Showing {{ products.data.length }}
            </p>

            <!-- Product grid -->
            <div v-if="products.data.length" class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4">
                <article v-for="book in products.data" :key="book.id" class="group flex flex-col">

                    <!-- Book cover -->

                    <a href="#"
                        class="relative block aspect-[3/4] overflow-hidden rounded-xl shadow-sm transition group-hover:shadow-lg">
                        <img
        :src="`/${book.image_path}`"
        :alt="book.title"
        class="h-full w-full object-cover"
    />
                    </a>

                    <!-- Book information -->
                    <div class="mt-3">
                        <h3 class="font-serif text-base font-semibold">
                            {{ book.title }}
                        </h3>

                        <p class="text-sm text-[#1B1B1F]/60">
                            {{ book.author }}
                        </p>

                        <div class="mt-2 flex items-center justify-between">
                            <span class="font-medium"> ${{ book.price }} </span>

                            <button
                                class="rounded-full border border-[#1B1B1F]/20 px-3 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:bg-[#B08D57] hover:text-white">
                                Add to cart
                            </button>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Empty state -->
            <p v-else class="py-16 text-center text-sm text-[#1B1B1F]/60">
                No books in this category yet.
            </p>

            <!-- Pagination -->
            <div v-if="products.links && products.links.length > 3" class="mt-10 flex flex-wrap justify-center gap-2">
                <button v-for="link in products.links" :key="link.label" :disabled="!link.url"
                    @click="link.url && router.get(link.url)" class="rounded-lg border px-4 py-2 text-sm transition"
                    :class="{
                        'bg-[#1B1B1F] text-[#F7F2E7]': link.active,
                        'opacity-50 cursor-not-allowed': !link.url,
                        'hover:border-[#B08D57]': link.url && !link.active,
                    }" v-html="link.label" />
            </div>
        </section>
    </div>
</template>
