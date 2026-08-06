<script setup>
import { ref, computed } from 'vue'
import AppLayout from "@/Layouts/AppLayout.vue";

defineOptions({
    layout: AppLayout,
});

// In your real app this would come from a Pinia cart store or an Inertia prop.
const items = ref([
  { id: 1, title: 'The Long Tide', author: 'Marta Ilves', price: 14.99, qty: 1, color: 'bg-[#5B7B6E]' },
  { id: 2, title: 'Paper Moons', author: 'D. R. Achebe', price: 12.5, qty: 2, color: 'bg-[#B08D57]' },
  { id: 3, title: 'Marrow & Ink', author: 'Colm Faraday', price: 16.0, qty: 1, color: 'bg-[#8C3B3B]' },
  { id: 4, title: 'Marrow & Ink', author: 'Colm Faraday', price: 16.0, qty: 1, color: 'bg-[#8C3B3B]' },
  { id: 5, title: 'Marrow & Ink', author: 'Colm Faraday', price: 16.0, qty: 1, color: 'bg-[#8C3B3B]' },
  { id: 6, title: 'Marrow & Ink', author: 'Colm Faraday', price: 16.0, qty: 1, color: 'bg-[#8C3B3B]' },
  { id: 7, title: 'Marrow & Ink', author: 'Colm Faraday', price: 16.0, qty: 1, color: 'bg-[#8C3B3B]' },
  { id: 8, title: 'Marrow & Ink', author: 'Colm Faraday', price: 16.0, qty: 1, color: 'bg-[#8C3B3B]' },
])

function increment(item) {
  item.qty++
}

function decrement(item) {
  if (item.qty > 1) item.qty--
}

function removeItem(id) {
  items.value = items.value.filter((i) => i.id !== id)
}

const subtotal = computed(() =>
  items.value.reduce((sum, i) => sum + i.price * i.qty, 0)
)
const shipping = computed(() => (items.value.length ? 4.0 : 0))
const total = computed(() => subtotal.value + shipping.value)
</script>

<template>
  <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
    <section class="mx-auto max-w-6xl px-6 py-12">
      <div class="mb-8">
        <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
          Your bag
        </p>
        <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">Cart</h1>
      </div>

      <div v-if="items.length" class="grid gap-10 lg:grid-cols-3">
        <!-- Cart items -->
        <ul class="divide-y divide-black/10 lg:col-span-2">
          <li
            v-for="item in items"
            :key="item.id"
            class="flex gap-4 py-6 first:pt-0"
          >
            <div :class="item.color" class="flex h-24 w-16 shrink-0 items-center justify-center rounded-lg p-2 shadow-sm">
              <span class="text-center font-serif text-xs font-semibold leading-snug text-white">
                {{ item.title }}
              </span>
            </div>

            <div class="flex flex-1 flex-col justify-between">
              <div class="flex items-start justify-between gap-4">
                <div>
                  <h3 class="font-serif text-base font-semibold">{{ item.title }}</h3>
                  <p class="text-sm text-[#1B1B1F]/60">{{ item.author }}</p>
                </div>
                <button
                  @click="removeItem(item.id)"
                  class="text-sm text-[#1B1B1F]/40 transition hover:text-[#8C3B3B]"
                  aria-label="Remove item"
                >
                  Remove
                </button>
              </div>

              <div class="mt-4 flex items-center justify-between">
                <div class="flex items-center gap-3 rounded-full border border-[#1B1B1F]/20 px-2 py-1">
                  <button
                    @click="decrement(item)"
                    class="flex h-6 w-6 items-center justify-center rounded-full text-sm transition hover:bg-[#1B1B1F]/10"
                    aria-label="Decrease quantity"
                  >
                    −
                  </button>
                  <span class="w-4 text-center text-sm">{{ item.qty }}</span>
                  <button
                    @click="increment(item)"
                    class="flex h-6 w-6 items-center justify-center rounded-full text-sm transition hover:bg-[#1B1B1F]/10"
                    aria-label="Increase quantity"
                  >
                    +
                  </button>
                </div>
                <span class="font-medium">${{ (item.price * item.qty).toFixed(2) }}</span>
              </div>
            </div>
          </li>
        </ul>

        <!-- Order summary -->
        <aside class="h-fit rounded-2xl border border-black/10 bg-white/50 p-6">
          <h2 class="font-serif text-lg font-semibold">Order summary</h2>

          <dl class="mt-4 space-y-3 text-sm">
            <div class="flex justify-between">
              <dt class="text-[#1B1B1F]/60">Subtotal</dt>
              <dd>${{ subtotal.toFixed(2) }}</dd>
            </div>
            <div class="flex justify-between">
              <dt class="text-[#1B1B1F]/60">Shipping</dt>
              <dd>${{ shipping.toFixed(2) }}</dd>
            </div>
            <div class="flex justify-between border-t border-black/10 pt-3 text-base font-semibold">
              <dt>Total</dt>
              <dd>${{ total.toFixed(2) }}</dd>
            </div>
          </dl>

          <button
            class="mt-6 w-full rounded-full bg-[#1B1B1F] py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]"
          >
            Checkout
          </button>
          <a
            href="/books"
            class="mt-3 block text-center text-sm font-medium text-[#1B1B1F]/60 hover:text-[#B08D57]"
          >
            Continue shopping
          </a>
        </aside>
      </div>

      <!-- Empty state -->
      <div v-else class="flex flex-col items-center py-24 text-center">
        <p class="font-serif text-xl font-semibold">Your cart is empty</p>
        <p class="mt-2 text-sm text-[#1B1B1F]/60">Browse the shelf and find something to read.</p>
        <a
          href="/books"
          class="mt-6 rounded-full bg-[#1B1B1F] px-6 py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]"
        >
          Browse books
        </a>
      </div>
    </section>
  </div>
</template>
