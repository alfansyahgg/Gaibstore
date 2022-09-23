<template>
    <div class="wrapper">
        <div class="product-checkout py-24 px-4 sm:px-16 bg-gray-200">
            <div class="flex gap-4 justify-between">
                <div
                    class="billing bg-white rounded-md p-8 shadow-md h-full"
                    style="width: 45%"
                >
                    <h3 class="font-bold text-3xl pb-8">Shipping Details</h3>
                    <profile-form
                        :photo="false"
                        v-model="formModel"
                    ></profile-form>
                </div>
                <div
                    class="summary bg-white rounded-md p-8 shadow-md h-3/4"
                    style="width: 40%"
                >
                    <div
                        class="flex items-center gap-2 text-3xl text-primary-500 pb-8 font-bold"
                    >
                        <n-icon>
                            <cart-outline></cart-outline>
                        </n-icon>
                        <h3 class="">Cart Summary</h3>
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
                        <div class="!py-4">
                            <n-button type="primary" class="!w-full">
                                <template #icon> </template>
                                <b>Pay</b>
                            </n-button>
                        </div>
                    </n-space>
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
const cart = computed(() => page.value.cart[0]);
const priceRef = computed(() => _.map(cart.value, (x) => x.price * x.quantity));
const subTotalPriceRef = computed(() => _.sum(priceRef.value));

// form Model
const formModel = useForm({
    _method: "put",
    photo: null,
    photoPreview: null,
    fname: null,
    lname: null,
    phone: {
        number: null,
        country: "ID",
    },
    address: null,
    city: {
        id: null,
        name: null,
    },
    zip_code: null,
});

const shippingPriceRef = ref(0);
const totalPriceRef = computed(
    () => subTotalPriceRef.value + shippingPriceRef.value
);
</script>
