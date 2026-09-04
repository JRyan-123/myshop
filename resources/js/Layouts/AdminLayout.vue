<script setup>
import AdminNav from '@/Components/Layout/AdminNav.vue';
import { Head, Link } from '@inertiajs/vue3';
import { LogOut } from 'lucide-vue-next';
import { ref } from 'vue'

import { usePage } from '@inertiajs/vue3'
import Flashtoast from '@/Components/Layout/Flashtoast.vue';

const page = usePage()

const getPageTitle = () => {
    const titles = [
        ['/admin/products/create', 'Create Book'],
        ['/admin/products/edit', 'Edit Book'],
        ['/admin/products', 'Books'],
        ['/admin/orders', 'Orders'],
        ['/admin/categories', 'Categories'],
        ['/admin', 'Dashboard'],
    ];

    const match = titles.find( ([url]) =>
        page.url.split('?')[0] === url
    )

    return match?.[1] ?? ''

}


const sidebarOpen = ref(false)

</script>

<template>
    <Head title="Admin" />
    <Flashtoast />
    <div class="min-h-screen bg-[#F4F4F2] text-[#1B1B1F]">
        <!-- Mobile overlay -->
        <div v-if="sidebarOpen" class="fixed inset-0 z-30 bg-black/30 lg:hidden" @click="sidebarOpen = false" />

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-40 w-64 transform bg-[#1B1B1F] text-[#F7F2E7] transition-transform lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex h-16 items-center gap-2 px-6">
                <span class="font-serif text-xl font-semibold">MyShop</span>
                <span class="rounded-full bg-[#B08D57] px-2 py-0.5 text-[10px] font-medium uppercase tracking-wide">
                    Admin
                </span>
            </div>

            <AdminNav  />

            <div class="absolute bottom-0 w-full border-t border-white/10 p-3">
                <Link :href="route('logout')" method="post" as="button"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-[#F7F2E7]/70 transition hover:bg-white/10 hover:text-[#F7F2E7]">
                    <LogOut />
                    Log out
                </Link>
            </div>
        </aside>

        <!-- Main column -->
        <div class="lg:pl-64">
            <!-- Topbar -->
            <header
                class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-black/10 bg-[#F4F4F2]/90 px-6 backdrop-blur">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden" aria-label="Toggle sidebar" @click="sidebarOpen = !sidebarOpen">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <slot name="header">
                        <h1 class="font-serif text-lg font-semibold capitalize">{{ getPageTitle() }}</h1>
                    </slot>
                </div>

                <div class="flex items-center gap-3">
                    <Link :href="route('profile.edit')"
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-[#1B1B1F] text-sm font-medium text-[#F7F2E7]">
                        A
                    </Link>
                </div>
            </header>

            <!-- Page content -->
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
