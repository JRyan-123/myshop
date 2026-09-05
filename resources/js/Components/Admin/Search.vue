<script setup>
const props = defineProps({
    placeholder: {
        type: String,
        default: 'Search...'
    }
})

const search = defineModel()
</script>

<template>
    <input v-model="search" type="text" :placeholder="placeholder"
        class="w-56 rounded-lg border border-black/10 bg-white px-4 py-2 text-sm outline-none transition focus:border-[#B08D57]" />      
</template>