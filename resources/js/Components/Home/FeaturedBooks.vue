<script setup>
const books = [
  {
    title: 'The Long Tide',
    author: 'Marta Ilves',
    price: '14.99',
    color: 'bg-[#5B7B6E]',
    badge: 'New',
  },
  {
    title: 'Paper Moons',
    author: 'D. R. Achebe',
    price: '12.50',
    color: 'bg-[#B08D57]',
    badge: null,
  },
  {
    title: 'Marrow & Ink',
    author: 'Colm Faraday',
    price: '16.00',
    color: 'bg-[#8C3B3B]',
    badge: 'Bestseller',
  },
  {
    title: 'Quiet Hours',
    author: 'Suki Nakamura',
    price: '11.25',
    color: 'bg-[#3B4C63]',
    badge: null,
  },
]
</script>

<template>
  <section class="mx-auto max-w-6xl px-6 py-16">
    <div class="mb-10 flex items-end justify-between">
      <div>
        <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
          Hand-picked this week
        </p>
        <h2 class="mt-2 font-serif text-3xl font-semibold">Featured books</h2>
      </div>
      <a href="/books" class="hidden text-sm font-medium hover:text-[#B08D57] sm:block">
        View all →
      </a>
    </div>

    <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4">
      <article
        v-for="book in books"
        :key="book.title"
        class="group flex flex-col"
      >
        <a href="#" class="relative block aspect-[3/4] overflow-hidden rounded-xl shadow-sm transition group-hover:shadow-lg">
          <div :class="book.color" class="flex h-full w-full items-center justify-center p-4">
            <span class="text-center font-serif text-lg font-semibold leading-snug text-white">
              {{ book.title }}
            </span>
          </div>
          <span
            v-if="book.badge"
            class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-medium text-[#1B1B1F]"
          >
            {{ book.badge }}
          </span>
        </a>

        <div class="mt-3">
          <h3 class="font-serif text-base font-semibold">{{ book.title }}</h3>
          <p class="text-sm text-[#1B1B1F]/60">{{ book.author }}</p>
          <div class="mt-2 flex items-center justify-between">
            <span class="font-medium">${{ book.price }}</span>
            <button
              class="rounded-full border border-[#1B1B1F]/20 px-3 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:bg-[#B08D57] hover:text-white"
            >
              Add to cart
            </button>
          </div>
        </div>
      </article>
    </div>
  </section>
</template>
