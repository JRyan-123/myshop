<script setup>
import { router } from "@inertiajs/vue3";
    const props = defineProps({
        metaLinks : [Object, String]
    })

const goTo = (url) => {
    if (!url) return

    router.get(url, {}, {
        preserveState: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="mt-10 flex flex-wrap justify-center gap-2">
        <button v-for="link in props.metaLinks" :disabled="!link.url"
            @click="goTo(link.url)" class="rounded-lg border px-4 py-2 text-sm transition" :class="{
                'bg-[#1B1B1F] text-[#F7F2E7]': link.active,
                'opacity-50 cursor-not-allowed': !link.url,
                'hover:border-[#B08D57]': link.url && !link.active,
            }" v-html="link.label" />
    </div>
</template>
