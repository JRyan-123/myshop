<script setup>
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css'

const page = usePage();

watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.success) {
            toast.success(flash.success)
        }

        if (flash?.error) {
            toast.error(flash.error)
        }
    },
    { deep: true }
)
</script>

<template>
    <Toaster position="top-right" />
</template>
