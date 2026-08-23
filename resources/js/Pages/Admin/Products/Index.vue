<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, computed } from 'vue'

defineOptions({
    layout: AdminLayout,
})

// In your real app this comes from a paginated Inertia prop, e.g.
// defineProps({ books: Object }) // Laravel paginator
const books = ref([
  { id: 1, title: 'The Long Tide', author: 'Marta Ilves', category: 'Fiction', price: 14.99, stock: 24, color: 'bg-[#5B7B6E]' },
  { id: 2, title: 'Paper Moons', author: 'D. R. Achebe', category: 'Romance', price: 12.5, stock: 3, color: 'bg-[#B08D57]' },
  { id: 3, title: 'Marrow & Ink', author: 'Colm Faraday', category: 'Mystery', price: 16.0, stock: 12, color: 'bg-[#8C3B3B]' },
  { id: 4, title: 'Quiet Hours', author: 'Suki Nakamura', category: 'Fiction', price: 11.25, stock: 0, color: 'bg-[#3B4C63]' },
  { id: 5, title: 'The Signal Sea', author: 'Owen Blackwood', category: 'Sci-Fi', price: 18.0, stock: 4, color: 'bg-[#2F4538]' },
  { id: 6, title: 'A Thousand Springs', author: 'Lila Moreau', category: 'Romance', price: 13.75, stock: 30, color: 'bg-[#6B5B95]' },
])

const search = ref('')
const categoryFilter = ref('All')
const categories = ['All', ...new Set(books.value.map((b) => b.category))]

const filteredBooks = computed(() =>
  books.value.filter((b) => {
    const matchesSearch =
      b.title.toLowerCase().includes(search.value.toLowerCase()) ||
      b.author.toLowerCase().includes(search.value.toLowerCase())
    const matchesCategory = categoryFilter.value === 'All' || b.category === categoryFilter.value
    return matchesSearch && matchesCategory
  })
)

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

    <template >
      <h1 class="font-serif text-lg font-semibold">Books</h1>
    </template>

    <!-- Toolbar -->
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
      <div class="flex flex-wrap items-center gap-3">
        <input
          v-model="search"
          type="text"
          placeholder="Search title or author..."
          class="w-56 rounded-lg border border-black/10 bg-white px-4 py-2 text-sm outline-none transition focus:border-[#B08D57]"
        />
        <select
          v-model="categoryFilter"
          class="rounded-lg border border-black/10 bg-white px-3 py-2 text-sm outline-none transition focus:border-[#B08D57]"
        >
          <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
        </select>
      </div>

      <a
        href="/admin/books/create"
        class="rounded-full bg-[#1B1B1F] px-5 py-2.5 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]"
      >
        + Add book
      </a>
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
          <tr v-for="book in filteredBooks" :key="book.id">
            <td class="px-5 py-3">
              <div class="flex items-center gap-3">
                <div :class="book.color" class="flex h-12 w-9 shrink-0 items-center justify-center rounded-md" />
                <div>
                  <p class="font-medium">{{ book.title }}</p>
                  <p class="text-xs text-[#1B1B1F]/60">{{ book.author }}</p>
                </div>
              </div>
            </td>
            <td class="px-5 py-3 text-[#1B1B1F]/70">{{ book.category }}</td>
            <td class="px-5 py-3">${{ book.price.toFixed(2) }}</td>
            <td class="px-5 py-3">
              <span class="rounded-full px-2.5 py-1 text-xs font-medium" :class="stockStyle(book.stock)">
                {{ book.stock === 0 ? 'Out of stock' : `${book.stock} left` }}
              </span>
            </td>
            <td class="px-5 py-3">
              <div class="flex justify-end gap-2">
                <a
                  :href="`/admin/books/${book.id}/edit`"
                  class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]"
                >
                  Edit
                </a>
                <button
                  @click="deleteBook(book.id)"
                  class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-medium text-[#8C3B3B] transition hover:border-[#8C3B3B] hover:bg-[#8C3B3B]/10"
                >
                  Delete
                </button>
              </div>
            </td>
          </tr>

          <tr v-if="!filteredBooks.length">
            <td colspan="5" class="px-5 py-10 text-center text-sm text-[#1B1B1F]/50">
              No books match your search.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <p class="mt-4 text-sm text-[#1B1B1F]/50">
      Showing {{ filteredBooks.length }} of {{ books.length }} books
    </p>
</template>
