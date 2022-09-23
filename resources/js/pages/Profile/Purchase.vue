<template>
    <profile-layout>
        <div class="wrapper">
            <div class="filter pb-8">
                <input-search
                    placeholder="Order Number"
                    v-model:search="searchRef"
                ></input-search>
            </div>
            <n-result
                v-if="orders.length < 1"
                status="error"
                title="Empty"
                description="No orders were found"
            >
                <template #footer>
                    <base-link :href="$route('welcome.shop')">
                        <n-button type="primary">Shop Now</n-button></base-link
                    >
                </template>
            </n-result>
            <div
                v-for="(order, index) in orders"
                :key="order.id"
                class="purchase-checkout rounded-md shadow-xl mb-8 !w-full"
            >
                <div
                    class="summary bg-white rounded-md p-8 shadow-md flex flex-col"
                    style="width: 100%"
                >
                    <div class="desc flex pb-4 border-b-green-500 border-b-2">
                        <div class="w-1/2">
                            <p class="text-primary-500 font-bold">
                                #{{ order.order_key }}
                            </p>
                        </div>
                        <div class="w-1/2 flex items-center justify-end">
                            <p></p>
                            <n-dropdown
                                trigger="hover"
                                :options="optionsRef"
                                @select="handleSelect"
                            >
                                <n-icon
                                    class="!cursor-pointer"
                                    @click="selectRow(order)"
                                >
                                    <ellipsis-vertical></ellipsis-vertical>
                                </n-icon>
                            </n-dropdown>
                        </div>
                    </div>

                    <n-space vertical>
                        <base-link
                            :href="
                                $route('profile.purchase-detail', {
                                    order: order.id,
                                })
                            "
                        >
                            <n-scrollbar
                                class="!h-40 !border-b-green-500 !border-b-2"
                            >
                                <list-cart
                                    v-model:cart="crt[index]"
                                ></list-cart>
                            </n-scrollbar>
                        </base-link>
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
                    </n-space>
                    <div class="!pt-3 !self-end">
                        <n-space>
                            <button-pay
                                v-if="order.payment_status == 1"
                                :token="order.snap_token"
                            ></button-pay>
                            <!-- <n-button type="error" @click="remove(order.id)">
                                <template #icon> </template>
                                <b>Remove</b>
                            </n-button> -->
                        </n-space>
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
import { EllipsisVertical } from "@vicons/ionicons5";

// utils
const page = computed(() => inject("$page").value.props);
const orders = computed(() => page.value.data.orders);
const route = inject("$route");

// ref
const formRef = ref(null);
const loadingRef = ref(false);
const searchRef = ref(null);
const selectedRow = ref(null);
const optionsRef = ref([
    {
        label: "Detail",
        key: "detail",
    },
    {
        label: "Remove",
        key: "remove",
    },
]);

const selectRow = (order) => {
    selectedRow.value = order;
};

const handleSelect = (key) => {
    switch (key) {
        case "detail":
            Inertia.visit(
                route("profile.purchase-detail", {
                    order: selectedRow.value.id,
                })
            );
        case "remove":
            Inertia.delete(
                route("checkout.remove-order", {
                    order: selectedRow.value.id,
                }),
                {
                    onSuccess: (page) => {
                        message.success(page.props.flash.success);
                    },
                }
            );
    }
};

const crt = _.map(orders.value, (order) =>
    _.map(order.carts, (item) => {
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
    })
);

watch(
    searchRef,
    _.throttle((value) => {
        Inertia.visit(route("profile.purchase"), {
            data: { search: value },
            preserveState: true,
        });
    }, 200)
);

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
