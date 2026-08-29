<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import { toast } from "vue-sonner";
import Pagination from "@/Components/Products/Pagination.vue";

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object,
});

const search = ref(props.filters.search ?? "");

const routerOptions = {
    preserveState: true,
    preserveScroll: true,
}

const searchProducts = () => {
    router.get(
        route("products.index"),
        {
            search: search.value,
            category: props.filters.category,
        },
        routerOptions

    );
};

const selectCategory = (category) => {
    router.get(
        route("products.index"),
        {
            search: search.value,
            category: category === "All" ? null : category,
        },
        routerOptions
    );
};


const addToCart = (productId) => {
    router.post(route('carts.store'), {
        product_id: productId,
        quantity: 1,
    },
        routerOptions,

    )

}
</script>

<template>

    <Head title="Products" />

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



            <!-- Search Filter -->
            <div class="mb-6 flex w-full gap-3">
                <input v-model="search" @keyup.enter="searchProducts" type="text" placeholder="Search books..."
                    class="w-10/12 rounded-lg border border-gray-300 px-4 py-2  focus:outline-none focus:border-[#B08D57] focus:ring-2 focus:ring-[#B08D57]" />

                <button @click="searchProducts" class="w-2/12 rounded-lg bg-[#1B1B1F] px-4 py-2 text-white">
                    Search
                </button>
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
                <button v-for="cat in props.categories" :key="cat.id" @click="selectCategory(cat.slug)"
                    class="rounded-full border px-4 py-2 text-sm font-medium transition" :class="filters.category === cat.slug
                        ? 'border-[#1B1B1F] bg-[#1B1B1F] text-[#F7F2E7]'
                        : 'border-[#1B1B1F]/20 hover:border-[#B08D57] hover:text-[#B08D57]'
                        ">
                    {{ cat.name }}
                </button>
            </div>



            <!-- Product count -->
            <p class="mb-6 text-sm text-[#1B1B1F]/60">
                Showing {{ products.data.length }} of {{ props.products.meta.total }} book{{ products.total === 1 ? '' :
                's' }}
            </p>



            <!-- Product grid -->
            <div v-if="products.data.length" class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4">
                <article v-for="book in props.products.data" :key="book.id" class="group flex flex-col">

                    <!-- Book cover -->
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

                    <!-- Book information -->
                    <div class="mt-3">
                        <Link :href="route('products.show', book)" class="font-serif text-base font-semibold">
                            {{ book.title }}
                        </Link>

                        <p class="text-sm text-[#1B1B1F]/60">
                            {{ book.author }}
                        </p>

                        <div class="mt-2 flex items-center justify-between">
                            <span class="font-medium"> ${{ book.price }} </span>

                            <button @click="addToCart(book.id)"
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
            <Pagination :metaLinks="props.products.meta.links" />
        </section>
    </div>
</template>
