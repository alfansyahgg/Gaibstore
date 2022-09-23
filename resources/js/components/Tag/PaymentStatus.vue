<template>
    <n-tag
        class="!font-bold"
        :bordered="false"
        :type="
            order.payment_status == 1
                ? ''
                : order.payment_status == 2
                ? 'success'
                : order.payment_status == 3
                ? 'error'
                : order.payment_status == 4
                ? 'warning'
                : ''
        "
    >
        {{
            order.payment_status == 1
                ? "Pending"
                : order.payment_status == 2
                ? "Payment Success"
                : order.payment_status == 3
                ? "Payment Expired"
                : order.payment_status == 4
                ? "Payment Canceled"
                : ""
        }}</n-tag
    >
</template>
<script setup>
// props
const props = defineProps({
    order: {
        type: Object,
        default: () => ({}),
    },
});

const order = computed(() => props.order);
</script>
