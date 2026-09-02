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
        type: Object,
        required: true
    },
    placeholder: String

})
const emit = defineEmits(['search'])
const search = defineModel('search')
const select = defineModel('select')
</script>

<template>
   <div class="flex flex-wrap items-center gap-3">
            <input v-model="search" type="text" :placeholder="placeholder"
                class="w-56 rounded-lg border border-black/10 bg-white px-4 py-2 text-sm outline-none transition focus:border-[#B08D57]" />
            <select v-model="select"
                class="rounded-lg border border-black/10 bg-white px-3 py-2 text-sm outline-none transition focus:border-[#B08D57]">
                <option value="">All</option>
                    <option v-for="s in props.option" :key="s" :value="s[value]">{{ s[label] }}</option>
            </select>
            <button @click="emit('search')" class=" rounded-lg bg-[#1B1B1F] px-4 py-2 text-white text-sm">
                Search
            </button>
        </div>
</template>
