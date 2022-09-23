<template>
    <div class="wrapper">
        <div class="product-checkout py-24 px-4 sm:px-16 bg-gray-200">
            <div class="flex">
                <div
                    class="summary bg-white rounded-md p-8 shadow-md flex flex-col"
                    style="width: 100%"
                >
                    <div
                        class="flex items-center gap-2 text-3xl text-primary-500 pb-4 font-bold"
                    >
                        <n-icon>
                            <cart-outline></cart-outline>
                        </n-icon>
                        <h3 class="">Order Summary</h3>
                    </div>

                    <n-space vertical>
                        <n-scrollbar class="!h-96">
                            <list-cart v-model:cart="cart"></list-cart>
                        </n-scrollbar>
                        <list-cart-total
                            class="!pt-4"
                            :subtotal="subTotalPriceRef"
                            :shipping="shippingPriceRef"
                            :total="totalPriceRef"
                        ></list-cart-total>
                    </n-space>
                    <div class="!pt-3">
                        <n-button type="primary" class="!w-full" @click="snap">
                            <template #icon> </template>
                            <b>Pay</b>
                        </n-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import RootLayout from "@/layouts/RootLayout.vue";
import PageLayout from "@/layouts/PageLayout.vue";
export default {
    layout: [RootLayout, PageLayout],
};
</script>
<script setup>
import { CartOutline } from "@vicons/ionicons5";
import { useForm } from "@inertiajs/inertia-vue3";
// utils
const page = computed(() => inject("$page").value.props);
const profile = computed(() => page.value.data.profile);
const cart = computed(() => page.value.cart[0]);
const priceRef = computed(() => _.map(cart.value, (x) => x.price * x.quantity));
const subTotalPriceRef = computed(() => _.sum(priceRef.value));

const shippingPriceRef = ref(0);
const totalPriceRef = computed(
    () => subTotalPriceRef.value + shippingPriceRef.value
);
</script>
