<script setup>
import { Link } from '@inertiajs/vue3';
import { ArrowLeftRight } from 'lucide-vue-next';


</script>

<template>
    <Link :href="route('home')"
        class="flex h-9 w-9 items-center justify-center rounded-full bg-[#1B1B1F] text-sm font-medium text-[#F7F2E7]">
    <ArrowLeftRight />
    </Link>
</template>