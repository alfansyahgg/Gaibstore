<template>
    <div class="wrapper">
        <dashboard-content-layout>
            <template #headerName> #{{ order.order_key }}</template>
            <template #content>
                <div class="content-wrapper">
                    <div class="notes pb-4 border-b-2 border-b-green-500">
                        <p>
                            Payment Status :
                            <tag-payment-status
                                :order="order"
                            ></tag-payment-status>
                        </p>
                    </div>
                    <n-scrollbar
                        class="!max-h-72 !border-b-green-500 !border-b-2"
                    >
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
                            <h3 class="font-bold text-2xl">
                                Transaction Details
                            </h3>

                            <table-transaction
                                v-if="transaction != null"
                            ></table-transaction>
                            <div v-else class="!pt-8">
                                <result-no-transaction></result-no-transaction>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </dashboard-content-layout>
    </div>
</template>
<script>
import RootLayout from "@/layouts/RootLayout.vue";
import DashboardLayout from "@/layouts/DashboardLayout.vue";
export default {
    layout: [RootLayout, DashboardLayout],
};
</script>
<script setup>
import { SaveOutline } from "@vicons/ionicons5";
import { useForm } from "@inertiajs/inertia-vue3";
import { request } from "@/helpers";
//icons
import { ArchiveOutline as ArchiveIcon } from "@vicons/ionicons5";
import { useMessage } from "naive-ui";
import imageAvatar from "@images/avatar.png";

// utils
const route = inject("$route");
const message = useMessage();
const data = computed(() => inject("$page").value.props.data);
const order = computed(() => data.value.order);
const shipping = computed(() => order.value.shipping);
const transaction = computed(() => data.value.transaction);
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
// ref
</script>
