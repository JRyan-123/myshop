<script setup>
import Toolbar from '@/Components/Admin/Toolbar.vue'
import Pagination from '@/Components/Products/Pagination.vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { formatPrice } from '@/utils/FormatPrice'
import { Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

defineOptions({
    layout: AdminLayout,
})
const props = defineProps({
    products: Object,
    categories: Object,
    filters: Object,
})
// In your real app this comes from a paginated Inertia prop, e.g.
// defineProps({ books: Object }) // Laravel paginator
const books = props.products.data

const search = ref(props.filters.search ?? "");
const category = ref(props.filters.category ?? "");
const categories = props.categories

const searchProducts = () => {
    router.get(
        route('admin.products.index',
        {
            search : search.value,
            category : category.value
        })
    )
}




function stockStyle(stock) {
    if (stock === 0) return 'bg-[#8C3B3B]/15 text-[#8C3B3B]'
    if (stock <= 5) return 'bg-[#B08D57]/15 text-[#B08D57]'
    return 'bg-[#5B7B6E]/15 text-[#5B7B6E]'
}

function deleteBook(id) {
    // Replace with a confirm dialog + router.delete(`/admin/books/${id}`)
    books.value = books.value.filter((b) => b.id !== id)
}
</script>

<template>



    <!-- Toolbar -->
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <Toolbar v-model:search="search" v-model:select="category" :option="categories" value="name" label="name"
            @search="searchProducts" placeholder="Search for books or authors"/>


        <Link :href="route('admin.products.create')"
            class="rounded-full bg-[#1B1B1F] px-5 py-2.5 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
            + Add book
        </Link>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-2xl border border-black/10 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-black/10 bg-black/[0.02]">
                <tr class="text-xs uppercase tracking-wide text-[#1B1B1F]/50">
                    <th class="px-5 py-3 font-medium">Book</th>
                    <th class="px-5 py-3 font-medium">Category</th>
                    <th class="px-5 py-3 font-medium">Price</th>
                    <th class="px-5 py-3 font-medium">Stock</th>
                    <th class="px-5 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                <tr v-for="book in props.products.data" :key="book.id">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="relative h-16 w-12 shrink-0 overflow-hidden rounded-lg shadow-sm">
                                <img :src="`/storage/${book.image_path}`" class="absolute inset-0 h-full w-full object-cover"
                                    alt="" />
                            </div>
                            <div>
                                <p class="font-medium">{{ book.title }}</p>
                                <p class="text-xs text-[#1B1B1F]/60">{{ book.author }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-[#1B1B1F]/70">{{ book.category.name }}</td>
                    <td class="px-5 py-3">{{ formatPrice(book.price) }}</td>
                    <td class="px-5 py-3">
                        <span class="rounded-full px-2.5 py-1 text-xs font-medium" :class="stockStyle(book.stock)">
                            {{ book.stock === 0 ? 'Out of stock' : `${book.stock} left` }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex justify-end gap-2">
                            <a :href="`/admin/prod/${book.id}/edit`"
                                class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]">
                                Edit
                            </a>
                            <button @click="deleteBook(book.id)"
                                class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-medium text-[#8C3B3B] transition hover:border-[#8C3B3B] hover:bg-[#8C3B3B]/10">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>

                <tr v-if="!products.data.length">
                    <td colspan="5" class="px-5 py-10 text-center text-sm text-[#1B1B1F]/50">
                        No books match your search.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <p class="mt-4 text-sm text-[#1B1B1F]/50">
        Showing {{ books.length }} of {{ props.products.meta.total }} books
    </p>
    <Pagination :metaLinks="props.products.meta.links" />
</template>
