<script setup>
const categories = [
  { name: 'Fiction', count: 482, color: 'bg-[#5B7B6E]' },
  { name: 'Mystery', count: 216, color: 'bg-[#8C3B3B]' },
  { name: 'Romance', count: 349, color: 'bg-[#B08D57]' },
  { name: 'Sci-Fi', count: 190, color: 'bg-[#3B4C63]' },
  { name: 'Biography', count: 127, color: 'bg-[#6B5B95]' },
  { name: 'Poetry', count: 88, color: 'bg-[#2F4538]' },
]
</script>

<template>
  <section class="mx-auto max-w-6xl px-6 py-16">
    <div class="mb-10 flex items-end justify-between">
      <div>
        <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
          Shop by shelf
        </p>
        <h2 class="mt-2 font-serif text-3xl font-semibold">Categories</h2>
      </div>
      <a href="/categories" class="hidden text-sm font-medium hover:text-[#B08D57] sm:block">
        View all →
      </a>
    </div>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
      <a
        v-for="cat in categories"
        :key="cat.name"
        href="#"
        class="group relative overflow-hidden rounded-2xl p-5 text-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
        :class="cat.color"
      >
        <p class="font-serif text-lg font-semibold">{{ cat.name }}</p>
        <p class="mt-1 text-xs text-white/70">{{ cat.count }} books</p>
        <span
          class="absolute -bottom-3 -right-3 font-serif text-6xl font-bold text-white/10 transition group-hover:text-white/20"
        >
          {{ cat.name.charAt(0) }}
        </span>
      </a>
    </div>
  </section>
</template>
