import { computed } from "vue";

export function useOrderSummary(cartItems) {
    const subtotal = computed(() =>
        cartItems.value.reduce(
            (sum, item) => {
                return sum + Number(item.price) * item.quantity
            },
            0
        )
    )

    const shipping = computed(() => {
        const itemCount = cartItems.value.length;

        if (itemCount === 0) return 0

        return 25 + (itemCount * 5)
    })

    const total = computed(() => subtotal.value + shipping.value)

    return {subtotal, shipping, total};
}
