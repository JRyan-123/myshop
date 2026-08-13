<script setup>
import { ref, computed } from 'vue'

// Order summary data — in your real app this comes from the cart store / an Inertia prop.
const items = ref([
  { id: 1, title: 'The Long Tide', price: 14.99, qty: 1, color: 'bg-[#5B7B6E]' },
  { id: 2, title: 'Paper Moons', price: 12.5, qty: 2, color: 'bg-[#B08D57]' },
  { id: 3, title: 'Marrow & Ink', price: 16.0, qty: 1, color: 'bg-[#8C3B3B]' },
])

const subtotal = computed(() => items.value.reduce((sum, i) => sum + i.price * i.qty, 0))
const shipping = computed(() => 4.0)
const total = computed(() => subtotal.value + shipping.value)

// Form state
const form = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
  city: '',
  zip: '',
})

const paymentMethods = [
  { id: 'gcash', label: 'GCash', hint: 'Pay via GCash e-wallet' },
  { id: 'card', label: 'Card', hint: 'Visa, Mastercard, JCB' },
  { id: 'ewallet', label: 'E-Wallet', hint: 'GrabPay, Maya, and more' },
]
const selectedPayment = ref('gcash')

function submitOrder() {
  // Hand off to your Laravel controller, e.g. via Inertia's router.post('/checkout', form.value)
  console.log('placing order', { form: form.value, payment: selectedPayment.value })
}
</script>

<template>
  <div class="min-h-screen bg-[#F7F2E7] text-[#1B1B1F]">
    <section class="mx-auto max-w-6xl px-6 py-12">
      <div class="mb-8">
        <p class="text-sm font-medium uppercase tracking-widest text-[#B08D57]">
          Almost there
        </p>
        <h1 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">Checkout</h1>
      </div>

      <form @submit.prevent="submitOrder" class="grid gap-10 lg:grid-cols-3">
        <!-- Left: forms -->
        <div class="space-y-8 lg:col-span-2">
          <!-- Contact info -->
          <div class="rounded-2xl border border-black/10 bg-white/50 p-6">
            <h2 class="font-serif text-lg font-semibold">Contact information</h2>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
              <input
                v-model="form.name"
                type="text"
                placeholder="Full name"
                required
                class="rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]"
              />
              <input
                v-model="form.phone"
                type="tel"
                placeholder="Phone number"
                required
                class="rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]"
              />
              <input
                v-model="form.email"
                type="email"
                placeholder="Email address"
                required
                class="rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57] sm:col-span-2"
              />
            </div>
          </div>

          <!-- Shipping address -->
          <div class="rounded-2xl border border-black/10 bg-white/50 p-6">
            <h2 class="font-serif text-lg font-semibold">Shipping address</h2>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
              <input
                v-model="form.address"
                type="text"
                placeholder="Street address"
                required
                class="rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57] sm:col-span-2"
              />
              <input
                v-model="form.city"
                type="text"
                placeholder="City"
                required
                class="rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]"
              />
              <input
                v-model="form.zip"
                type="text"
                placeholder="ZIP code"
                required
                class="rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]"
              />
            </div>
          </div>

          <!-- Payment method -->
          <div class="rounded-2xl border border-black/10 bg-white/50 p-6">
            <h2 class="font-serif text-lg font-semibold">Payment method</h2>
            <div class="mt-4 grid gap-3 sm:grid-cols-3">
              <label
                v-for="method in paymentMethods"
                :key="method.id"
                class="cursor-pointer rounded-xl border p-4 text-sm transition"
                :class="
                  selectedPayment === method.id
                    ? 'border-[#1B1B1F] bg-[#1B1B1F] text-[#F7F2E7]'
                    : 'border-black/10 bg-white hover:border-[#B08D57]'
                "
              >
                <input
                  v-model="selectedPayment"
                  type="radio"
                  name="payment"
                  :value="method.id"
                  class="sr-only"
                />
                <span class="block font-medium">{{ method.label }}</span>
                <span class="mt-1 block text-xs opacity-70">{{ method.hint }}</span>
              </label>
            </div>
          </div>
        </div>

        <!-- Right: order summary -->
        <aside class="h-fit rounded-2xl border border-black/10 bg-white/50 p-6">
          <h2 class="font-serif text-lg font-semibold">Order summary</h2>

          <ul class="mt-4 space-y-4">
            <li v-for="item in items" :key="item.id" class="flex items-center gap-3">
              <div :class="item.color" class="flex h-14 w-10 shrink-0 items-center justify-center rounded-md">
                <span class="text-center font-serif text-[9px] font-semibold leading-snug text-white">
                  {{ item.title }}
                </span>
              </div>
              <div class="flex flex-1 items-center justify-between text-sm">
                <div>
                  <p class="font-medium">{{ item.title }}</p>
                  <p class="text-[#1B1B1F]/60">Qty {{ item.qty }}</p>
                </div>
                <span>${{ (item.price * item.qty).toFixed(2) }}</span>
              </div>
            </li>
          </ul>

          <dl class="mt-6 space-y-3 border-t border-black/10 pt-4 text-sm">
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
            type="submit"
            class="mt-6 w-full rounded-full bg-[#1B1B1F] py-3 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]"
          >
            Place order
          </button>
        </aside>
      </form>
    </section>
  </div>
</template>
