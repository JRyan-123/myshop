<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    value: {
         type: [String, Number],
        required: true
    },
    comparison: {
        type: Number,
        required: true
    },
    color: {
        type: String,
        default: 'text-gray-500'
    }
})

const color = computed(() => {
    if (props.comparison > 0) return 'text-green-600'
    if (props.comparison < 0) return 'text-red-600'

    return 'text-gray-500'
})

</script>

<template>
    <div class="rounded-2xl border border-black/10 bg-white p-5">
        <p class="text-sm text-[#1B1B1F]/60">{{ props.label }}</p>
        <p class="mt-2 font-serif text-2xl font-semibold">{{ props.value }}</p>
        <p class="mt-1 text-xs font-medium" :class="color">
            {{ props.comparison }}% vs last month
        </p>
    </div>
</template>
