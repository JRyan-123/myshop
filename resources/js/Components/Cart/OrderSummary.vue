<script setup>
import { formatPrice } from '@/utils/FormatPrice';


const props = defineProps({
    subtotal: {
        type: [Number, String],
        required: true
    },
    shipping_fee: {
        type:  [Number, String],
        required: true
    },
    total: {
        type:  [Number, String],
        required: true
    }
})
</script>

<template>
    <aside class="h-fit rounded-2xl border border-black/10 bg-white/50 p-6">
        <h2 class="font-serif text-lg font-semibold">Order summary</h2>

        <slot name="forDetails" />

        <dl class="mt-5 space-y-3 text-sm">
            <div class="flex justify-between">
                <dt class="text-[#1B1B1F]/60">Subtotal</dt>
                <dd>{{ formatPrice(subtotal) }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-[#1B1B1F]/60">Shipping</dt>
                <dd>{{  formatPrice(shipping_fee)  }}</dd>
            </div>
            <div class="flex justify-between border-t border-black/10 pt-3 text-base font-semibold">
                <dt>Total</dt>
                <dd>{{  formatPrice(total) }}</dd>
            </div>
        </dl>

        <slot name="forButtons" />

    </aside>
</template>
