<template>
    <n-button type="primary" @click="pay(token)">
        <template #icon>
            <n-icon>
                <cash-outline />
            </n-icon>
        </template>
        <b>Pay</b>
    </n-button>
</template>

<script setup>
import { CashOutline } from "@vicons/ionicons5";

// props
const props = defineProps({
    token: {
        type: Object,
        default: () => ({}),
    },
});
function pay(token) {
    window.snap.pay(token, {
        // Optional
        onSuccess: function (result) {
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            console.log(result);
        },
        // Optional
        onPending: function (result) {
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            console.log(result);
        },
        // Optional
        onError: function (result) {
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            console.log(result);
        },
    });
}
</script>
