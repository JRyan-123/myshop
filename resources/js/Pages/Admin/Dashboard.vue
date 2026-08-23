<script setup>
import { Link } from '@inertiajs/vue3';
import { LogOut } from 'lucide-vue-next';
import { ref } from 'vue'

// Pass the current section in from each page so the right nav item highlights, e.g.
// <AdminLayout current="orders">
const props = defineProps({
  current: { type: String, default: '' },
})

const sidebarOpen = ref(false)

const nav = [
  { key: 'dashboard', label: 'Dashboard', href: '/admin', icon: 'M4 6h16M4 12h16M4 18h7' },
  { key: 'books', label: 'Books', href: '/admin/books', icon: 'M4 19.5A2.5 2.5 0 016.5 17H20M4 4.5A2.5 2.5 0 016.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15z' },
  { key: 'categories', label: 'Categories', href: '/admin/categories', icon: 'M4 6a2 2 0 012-2h4l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2V6z' },
  { key: 'orders', label: 'Orders', href: '/admin/orders', icon: 'M3 3h2l2.4 12.2a1 1 0 001 .8h9.2a1 1 0 001-.8L20 7H6' },
  { key: 'customers', label: 'Customers', href: '/admin/customers', icon: 'M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M12 3a4 4 0 110 8 4 4 0 010-8z' },
  { key: 'settings', label: 'Settings', href: '/admin/settings', icon: 'M12 15a3 3 0 100-6 3 3 0 000 6z' },
]
</script>

<template>
  <div class="min-h-screen bg-[#F4F4F2] text-[#1B1B1F]">
    <!-- Mobile overlay -->
    <div
      v-if="sidebarOpen"
      class="fixed inset-0 z-30 bg-black/30 lg:hidden"
      @click="sidebarOpen = false"
    />

    <!-- Sidebar -->
    <aside
      class="fixed inset-y-0 left-0 z-40 w-64 transform bg-[#1B1B1F] text-[#F7F2E7] transition-transform lg:translate-x-0"
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
      <div class="flex h-16 items-center gap-2 px-6">
        <span class="font-serif text-xl font-semibold">MyShop</span>
        <span class="rounded-full bg-[#B08D57] px-2 py-0.5 text-[10px] font-medium uppercase tracking-wide">
          Admin
        </span>
      </div>

      <nav class="mt-4 space-y-1 px-3">
        <a
          v-for="item in nav"
          :key="item.key"
          :href="item.href"
          class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
          :class="
            current === item.key
              ? 'bg-[#B08D57] text-[#1B1B1F]'
              : 'text-[#F7F2E7]/70 hover:bg-white/10 hover:text-[#F7F2E7]'
          "
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
          </svg>
          {{ item.label }}
        </a>
      </nav>

      <div class="absolute bottom-0 w-full border-t border-white/10 p-3">
        <Link :href="route('logout')" method="post" as="button"
          class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-[#F7F2E7]/70 transition hover:bg-white/10 hover:text-[#F7F2E7]">
            <LogOut/>
          Log out
        </Link>
      </div>
    </aside>

    <!-- Main column -->
    <div class="lg:pl-64">
      <!-- Topbar -->
      <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-black/10 bg-[#F4F4F2]/90 px-6 backdrop-blur">
        <div class="flex items-center gap-4">
          <button class="lg:hidden" aria-label="Toggle sidebar" @click="sidebarOpen = !sidebarOpen">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <slot name="header">
            <h1 class="font-serif text-lg font-semibold capitalize">{{ current }}</h1>
          </slot>
        </div>

        <div class="flex items-center gap-3">
          <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#1B1B1F] text-sm font-medium text-[#F7F2E7]">
            A
          </div>
        </div>
      </header>

      <!-- Page content -->
      <main class="p-6">
        <slot />
      </main>
    </div>
  </div>
</template>
