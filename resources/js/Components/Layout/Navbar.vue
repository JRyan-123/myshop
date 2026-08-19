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
                <li>Categories</li>

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
                                        {{ user.name }}
                                        <div class="flex">
                                        <CircleUser />
                                        <ChevronDown />
                                        </div>

                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    Profile
                                </DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
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
        <div v-if="menuOpen" class="border-t border-black/10 bg-[#F7F2E7] px-6 py-4 md:hidden">
            <ul class="flex flex-col gap-4 text-sm font-medium">
                <li><a href="#" class="hover:text-[#B08D57]">Browse</a></li>
                <li><a href="#" class="hover:text-[#B08D57]">Genres</a></li>
                <li><a href="#" class="hover:text-[#B08D57]">Authors</a></li>
                <li><a href="#" class="hover:text-[#B08D57]">About</a></li>
                <li class="pt-2"><a href="/login" class="hover:text-[#B08D57]">Sign in</a></li>
                <li>
                    <a href="/register" class="inline-block rounded-full bg-[#1B1B1F] px-5 py-2 text-[#F7F2E7]">
                        Get started
                    </a>
                </li>
            </ul>
        </div>
    </header>
</template>
