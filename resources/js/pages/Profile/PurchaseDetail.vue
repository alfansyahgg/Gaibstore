<template>
    <profile-layout>
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="notes flex pb-4 border-b-2 border-b-green-500">
                    <p class="w-1/2">
                        Payment Status :
                        <tag-payment-status :order="order"></tag-payment-status>
                    </p>
                    <div class="w-1/2 flex gap-2 justify-end">
                        <button-pay
                            v-if="order.payment_status == 1"
                            :token="order.snap_token"
                        ></button-pay>
                        <button-remove-purchase
                            :id="order.id"
                        ></button-remove-purchase>
                    </div>
                </div>

                <n-scrollbar class="!max-h-72 !border-b-green-500 !border-b-2">
                    <list-cart v-model:cart="cart"></list-cart>
                </n-scrollbar>
                <list-cart-total
                    class="!pt-4"
                    :subtotal="
                        parseInt(
                            parseInt(order.total_price) -
                                parseInt(order.shipping.shipping_cost)
                        )
                    "
                    :shipping="parseInt(order.shipping.shipping_cost)"
                    :total="parseInt(order.total_price)"
                ></list-cart-total>

                <div class="details py-12 flex">
                    <div class="shipping w-1/2">
                        <h3 class="font-bold text-2xl">Shipping Details</h3>
                        <table-shipping></table-shipping>
                    </div>
                    <div class="transaction w-1/2">
                        <h3 class="font-bold text-2xl">Transaction Details</h3>

                        <table-transaction
                            v-if="transaction != null"
                        ></table-transaction>
                        <div v-else class="!pt-8">
                            <result-no-transaction></result-no-transaction>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </profile-layout>
</template>
<script>
import RootLayout from "@/layouts/RootLayout.vue";
import PageLayout from "@/layouts/PageLayout.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
    layout: [RootLayout, PageLayout],
};
</script>
<script setup>
// ref
const formRef = ref(null);
const loadingRef = ref(false);
const searchRef = ref(null);

// utils
const page = computed(() => inject("$page").value.props);
const order = computed(() => page.value.data.order);
const shipping = computed(() => order.value.shipping);
const transaction = computed(() => page.value.data.transaction);
const cart = _.map(order.value.carts, (item) => {
    return {
        id: item.variant_id,
        name: item.variant.products.name,
        brand: item.variant.products.brand,
        color: item.variant.color,
        size: item.variant.size,
        price: item.variant.products.price,
        quantity: item.quantity,
        preview: item.variant.products.media[0].preview_url,
    };
});

function remove(id) {
    console.log(id);
    Inertia.delete(
        route("checkout.remove-order", {
            order: id,
        }),
        {
            onFinish: () => {
                loadingRef.value = false;
            },
            onStart: () => {
                loadingRef.value = true;
            },
        }
    );
}

onMounted(() => {
    let midtrans = document.createElement("script");
    midtrans.setAttribute(
        "src",
        "https://app.sandbox.midtrans.com/snap/snap.js"
    );
    midtrans.setAttribute("data-client-key", "SB-Mid-client-RN-YUnJ46LDBImxv");
    document.head.appendChild(midtrans);
});
</script>
