<template>
    <div class="cart-total flex justify-end">
        <div class="w-3/4">
            <h3>Subtotal</h3>
            <h3>Shipping</h3>
            <h3 class="font-semibold">Total</h3>
        </div>
        <div class="w-2/4 flex flex-col items-end">
            <h3>Rp. {{ subTotalPrice.toLocaleString("id-ID") }}</h3>
            <h3>Rp. {{ shippingPrice.toLocaleString("id-ID") }}</h3>
            <h3 class="font-bold">
                Rp. {{ totalPrice.toLocaleString("id-ID") }}
            </h3>
        </div>
    </div>
</template>
<script setup>
// props
const props = defineProps({
    subtotal: {
        type: Number,
        default: 0,
    },
    shipping: {
        type: Number,
        default: 0,
    },
    total: {
        type: Number,
        default: 0,
    },
});

const subTotalPrice = computed(() => props.subtotal);
const shippingPrice = computed(() => props.shipping);
const totalPrice = computed(() => props.total);
</script>
