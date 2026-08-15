<script setup>
const props = defineProps({
    subtotal: {
        type: Number,
        required: true
    },
    shipping: {
        type: Number,
        required: true
    },
    total: {
        type: Number,
        required: true
    }
})
</script>

<template>
    <aside class="h-fit rounded-2xl border border-black/10 bg-white/50 p-6">
        <h2 class="font-serif text-lg font-semibold">Order summary</h2>

        <dl class="mt-4 space-y-3 text-sm">
            <div class="flex justify-between">
                <dt class="text-[#1B1B1F]/60">Subtotal</dt>
                <dd>₱{{ subtotal.toFixed(2) }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-[#1B1B1F]/60">Shipping</dt>
                <dd>₱{{ shipping.toFixed(2) }}</dd>
            </div>
            <div class="flex justify-between border-t border-black/10 pt-3 text-base font-semibold">
                <dt>Total</dt>
                <dd>₱{{ total.toFixed(2) }}</dd>
            </div>
        </dl>

        <slot/>

    </aside>
</template>
