<script setup>
import { ref, onMounted, onUnmounted, compile, computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { ChevronDown, CircleUser, ShoppingBag, ShoppingCart } from 'lucide-vue-next'
import Dropdown from '../Dropdown.vue'
import DropdownLink from '../DropdownLink.vue'


const menuOpen = ref(false)
const scrolled = ref(false)

const onScroll = () => {
    scrolled.value = window.scrollY > 10
}

const page = usePage();

const user = computed(() => page.props.auth.user)

onMounted(() => {
    window.addEventListener('scroll', onScroll)
    onScroll()
})

onUnmounted(() => {
    window.removeEventListener('scroll', onScroll)
})
</script>

<template>
    <header class="sticky top-0 z-50 border-b transition-colors"
        :class="scrolled ? 'bg-[#F7F2E7]/90 backdrop-blur border-black/10' : 'bg-transparent border-transparent'">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <a href="/" class="font-serif text-xl font-semibold tracking-tight">
                MyShop
            </a>

            <ul class="hidden items-center gap-8 text-sm font-medium md:flex">
                <li>
                    <Link :href="route('products.index')" class="hover:text-[#B08D57]">
                        Browse
                    </Link>
                </li>
                <li>About</li>

            </ul>

            <template v-if="user">
                <div class="hidden items-center gap-4 md:flex">
                    <Link :href="route('carts.index')" class="text-sm font-medium hover:text-[#B08D57]">
                        <ShoppingCart />
                    </Link>
                    <Link :href="route('orders.index')" class="text-sm font-medium hover:text-[#B08D57]">
                        <ShoppingBag />
                    </Link>


                    <div class="relative text-center ms-3">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex gap-2 items-center text-sm font-medium hover:text-[#B08D57]">
                                        <!-- Profile -->
                                        <div class=" flex items-center gap-3">
                                            <div
                                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#1B1B1F] text-sm font-semibold uppercase text-[#F7F2E7]">
                                                {{ user.name?.charAt(0) || 'U' }}
                                            </div>

                                            <div class="min-w-0">
                                                <p class="truncate text-sm font-semibold text-[#1B1B1F]">
                                                    {{ user.name }}
                                                </p>
                                                <p class="truncate text-xs font-normal text-[#1B1B1F]/60">
                                                    {{ user.email }}
                                                </p>
                                            </div>
                                        </div>

                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    Profile
                                </DropdownLink>
                                <DropdownLink :href="route('admin.index')" v-if="user.role === 'admin'">
                                    Admin Dashboard
                                </DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    Log Out
                                </DropdownLink>

                            </template>

                        </Dropdown>

                    </div>
                    <ToClient />
                </div>
            </template>

            <template v-else>
                <div class="hidden items-center gap-4 md:flex">
                    <Link :href="route('login')" class="text-sm font-medium hover:text-[#B08D57]">
                        Sign in
                    </Link>

                    <Link :href="route('register')"
                        class="rounded-full bg-[#1B1B1F] px-5 py-2 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
                        Get started
                    </Link>
                </div>
            </template>


            <!-- Mobile menu toggle -->
            <button class="md:hidden" aria-label="Toggle menu" @click="menuOpen = !menuOpen">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path v-if="!menuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </nav>

        <!-- Mobile menu -->

        <!-- Mobile menu -->
        <div v-if="menuOpen" class="border-t border-black/10 bg-[#F7F2E7] px-6 py-5 md:hidden">
            <!-- Navigation links -->
            <ul class="flex flex-col gap-1 text-sm font-medium">
                <li>
                    <a href="#" @click="menuOpen = false"
                        class="block rounded-lg px-3 py-2.5 transition hover:bg-black/5 hover:text-[#B08D57]">
                        Browse Books
                    </a>
                </li>

                <li>
                    <a href="#" @click="menuOpen = false"
                        class="block rounded-lg px-3 py-2.5 transition hover:bg-black/5 hover:text-[#B08D57]">
                        About
                    </a>
                </li>
            </ul>

            <!-- Guest menu -->
            <div v-if="!user" class="mt-4 border-t border-black/10 pt-4">
                <div class="flex flex-col gap-3">
                    <a href="/login" @click="menuOpen = false"
                        class="block rounded-full border border-[#1B1B1F]/20 px-5 py-2.5 text-center font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]">
                        Sign in
                    </a>

                    <a href="/register" @click="menuOpen = false"
                        class="block rounded-full bg-[#1B1B1F] px-5 py-2.5 text-center font-medium text-[#F7F2E7] transition hover:bg-[#B08D57] hover:text-[#1B1B1F]">
                        Get started
                    </a>
                </div>
            </div>

            <!-- Authenticated user menu -->
            <div v-else class="mt-4 border-t border-black/10 pt-4">
                <!-- User profile -->
                <div class="mb-4 flex items-center gap-3 px-3">
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#1B1B1F] text-sm font-semibold uppercase text-[#F7F2E7]">
                        {{ user.name?.charAt(0) || 'U' }}
                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-[#1B1B1F]">
                            {{ user.name }}
                        </p>
                        <p class="truncate text-xs font-normal text-[#1B1B1F]/60">
                            {{ user.email }}
                        </p>
                    </div>
                </div>

                <ul class="flex flex-col gap-1 text-sm font-medium">
                    <li>
                        <a href="/orders" @click="menuOpen = false"
                            class="block rounded-lg px-3 py-2.5 transition hover:bg-black/5 hover:text-[#B08D57]">
                            My Orders
                        </a>
                    </li>

                    <li>
                        <a href="/profile" @click="menuOpen = false"
                            class="block rounded-lg px-3 py-2.5 transition hover:bg-black/5 hover:text-[#B08D57]">
                            My Account
                        </a>
                    </li>

                    <!-- Optional admin link -->
                    <li v-if="user.role === 'admin'">
                        <a href="/admin" @click="menuOpen = false"
                            class="block rounded-lg px-3 py-2.5 transition hover:bg-black/5 hover:text-[#B08D57]">
                            Admin Dashboard
                        </a>
                    </li>
                </ul>

                <!-- Logout -->
                <div class="mt-4 border-t border-black/10 pt-4">
                    <button type="button" @click="logout"
                        class="w-full rounded-full border border-black/15 px-5 py-2.5 text-center font-medium text-[#1B1B1F] transition hover:border-red-300 hover:bg-red-50 hover:text-red-700">
                        Sign out
                    </button>
                </div>
            </div>
        </div>

    </header>
</template>
