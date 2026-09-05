<script setup>
const props = defineProps({
    value: {
        type: String,
        default: 'value'
    },
    label: {
        type: String,
        default: 'label'
    },
    option: {
        type: [Array, Object],
        required: true
    },
    defaultOption: {
        type: String,
        default: 'All'
    },

})

const model = defineModel()
</script>

<template>
    <select v-model="model"
        class="rounded-lg border border-black/10 bg-white px-3 py-2 text-sm outline-none transition focus:border-[#B08D57]">
        <option value="">{{ defaultOption }}</option>
        <option v-for="s in props.option" :key="s[value]" :value="s[value]">{{ s[label] }}</option>
    </select>
</template>