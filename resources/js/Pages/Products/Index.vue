<script setup>

import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({
    layout: AppLayout
})
// In your real app these would come in as props from the Inertia controller, e.g.
// defineProps({ books: Array })
const books = [
  { id: 1, title: 'The Long Tide', author: 'Marta Ilves', price: 14.99, category: 'Fiction', color: 'bg-[#5B7B6E]' },
  { id: 2, title: 'Paper Moons', author: 'D. R. Achebe', price: 12.5, category: 'Romance', color: 'bg-[#B08D57]' },
  { id: 3, title: 'Marrow & Ink', author: 'Colm Faraday', price: 16.0, category: 'Mystery', color: 'bg-[#8C3B3B]' },
  { id: 4, title: 'Quiet Hours', author: 'Suki Nakamura', price: 11.25, category: 'Fiction', color: 'bg-[#3B4C63]' },
  { id: 5, title: 'The Signal Sea', author: 'Owen Blackwood', price: 18.0, category: 'Sci-Fi', color: 'bg-[#2F4538]' },
  { id: 6, title: 'A Thousand Springs', author: 'Lila Moreau', price: 13.75, category: 'Romance', color: 'bg-[#6B5B95]' },
  { id: 7, title: 'The Last Ledger', author: 'Henrik Voss', price: 15.5, category: 'Mystery', color: 'bg-[#8C3B3B]' },
  { id: 8, title: 'Wander Light', author: 'Amara Osei', price: 10.0, category: 'Poetry', color: 'bg-[#B08D57]' },
  { id: 9, title: 'Static Bloom', author: 'Rin Kobayashi', price: 17.25, category: 'Sci-Fi', color: 'bg-[#3B4C63]' },
  { id: 10, title: 'The Quiet Frontier', author: 'Eli Marsh', price: 12.0, category: 'Biography', color: 'bg-[#2F4538]' },
  { id: 11, title: 'Salt and Ash', author: 'Nadia Petrov', price: 14.0, category: 'Fiction', color: 'bg-[#5B7B6E]' },
  { id: 12, title: 'Midnight Almanac', author: 'Toby Reyes', price: 19.99, category: 'Biography', color: 'bg-[#6B5B95]' },
]

const categories = ['All', ...new Set(books.map((b) => b.category))]
const selectedCategory = ref('All')

const filteredBooks = computed(() =>
  selectedCategory.value === 'All'
    ? books
    : books.filter((b) => b.category === selectedCategory.value)
)
</script>

<template>
  <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
    <section class="mx-auto max-w-6xl px-6 py-12">
      <!-- Page header -->
      <div class="mb-8">
        <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
          The full catalog
        </p>
        <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">All books</h1>
      </div>

      <!-- Category filter -->
      <div class="mb-8 flex flex-wrap gap-2">
        <button
          v-for="cat in categories"
          :key="cat"
          @click="selectedCategory = cat"
          class="rounded-full border px-4 py-2 text-sm font-medium transition"
          :class="
            selectedCategory === cat
              ? 'border-[#1B1B1F] bg-[#1B1B1F] text-[#F7F2E7]'
              : 'border-[#1B1B1F]/20 hover:border-[#B08D57] hover:text-[#B08D57]'
          "
        >
          {{ cat }}
        </button>
      </div>

      <p class="mb-6 text-sm text-[#1B1B1F]/60">
        {{ filteredBooks.length }} book{{ filteredBooks.length === 1 ? '' : 's' }}
      </p>

      <!-- Product grid -->
      <div
        v-if="filteredBooks.length"
        class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4"
      >
        <article v-for="book in filteredBooks" :key="book.id" class="group flex flex-col">
          <a href="#" class="relative block aspect-[3/4] overflow-hidden rounded-xl shadow-sm transition group-hover:shadow-lg">
            <div :class="book.color" class="flex h-full w-full items-center justify-center p-4">
              <span class="text-center font-serif text-lg font-semibold leading-snug text-white">
                {{ book.title }}
              </span>
            </div>
          </a>

          <div class="mt-3">
            <h3 class="font-serif text-base font-semibold">{{ book.title }}</h3>
            <p class="text-sm text-[#1B1B1F]/60">{{ book.author }}</p>
            <div class="mt-2 flex items-center justify-between">
              <span class="font-medium">${{ book.price.toFixed(2) }}</span>
              <button
                class="rounded-full border border-[#1B1B1F]/20 px-3 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:bg-[#B08D57] hover:text-white"
              >
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
    </section>
  </div>
</template>
