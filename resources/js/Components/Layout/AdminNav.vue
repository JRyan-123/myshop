<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import {  BookOpenText, LayoutDashboard, LayoutList, ShoppingBag } from 'lucide-vue-next';

const page = usePage()

const isActive = (url) => page.url === url
</script>

<template>
    <nav>
        <Link
            :href="route('admin.index')"
            :class="{ active: isActive('/admin') }"
             class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition m-3"
        >
            <LayoutDashboard/>
            Dashboard
        </Link>

        <Link
            :href="route('admin.orders.index')"
            :class="{ active: isActive('/admin/orders') }"
             class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition m-3"
        >
            <ShoppingBag/>
            Orders
        </Link>

        <Link
            :href="route('admin.products.index')"
            :class="{ active: isActive('/admin/products') }"
             class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition m-3"
        >
            <BookOpenText />
            Books
        </Link>

        <Link
            :href="route('admin.categories.index')"
            :class="{ active: isActive('/admin/categories') }"
             class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition m-3"
        >
            <LayoutList/>
            Categories
        </Link>
    </nav>
</template>
