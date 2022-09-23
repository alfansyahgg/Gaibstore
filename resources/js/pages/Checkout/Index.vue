<template>
    <div class="wrapper">
        <div class="product-checkout py-24 px-4 sm:px-16 bg-gray-200">
            <div class="flex gap-4 justify-between">
                <div
                    class="billing bg-white rounded-md p-8 shadow-md h-auto"
                    style="width: 45%"
                >
                    <h3 class="font-bold text-3xl pb-4">Shipping Details</h3>
                    <checkout-form
                        ref="formRef"
                        v-model="formModel"
                        :cost="cost"
                    ></checkout-form>
                </div>
                <div
                    class="summary bg-white rounded-md p-8 shadow-md h-full"
                    style="width: 50%"
                >
                    <div
                        class="flex items-center gap-2 text-3xl text-primary-500 pb-4 font-bold"
                    >
                        <n-icon>
                            <cart-outline></cart-outline>
                        </n-icon>
                        <h3 class="">Cart Summary</h3>
                    </div>

                    <n-space vertical>
                        <n-scrollbar class="!h-72">
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
                        <n-button
                            type="primary"
                            class="!w-full"
                            :disabled="shipModel.processing"
                            :loading="shipModel.processing"
                            @click="placeOrder"
                        >
                            <template #icon> </template>
                            <b>Place Order</b>
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
import { Inertia } from "@inertiajs/inertia";
import { useMessage } from "naive-ui";
import { useForm } from "@inertiajs/inertia-vue3";
// utils
const { _ } = window;
const route = inject("$route");
const message = useMessage();

// ref
const formRef = ref(null);
const page = computed(() => inject("$page").value.props);
const profile = computed(() => page.value.data.profile);
const cart = computed(() => page.value.cart[0]);
console.log(cart.value);
const priceRef = computed(() => _.map(cart.value, (x) => x.price * x.quantity));
const subTotalPriceRef = computed(() => _.sum(priceRef.value));
const shippingPriceRef = ref(0);
const shippingPriceComp = computed(() => shippingPriceRef.value);
const totalPriceRef = computed(
    () => subTotalPriceRef.value + shippingPriceComp.value
);
const cost = computed(() => page.value.data.cost);
const rajaongkir = computed(() => cost.value.rajaongkir);

// form Model
const formModel = reactive({
    fname: profile.value.first_name,
    lname: profile.value.last_name,
    phone: {
        number: profile.value.phone_number,
        country: profile.value.country,
    },
    address: profile.value.address,
    city: {
        id: profile.value.city_id,
        name: profile.value.city,
    },
    zip_code: profile.value.zip_code,
    courier: {
        code: null,
        name: null,
        cost: null,
        service: null,
        etd: null,
    },
});
const shipModel = useForm({
    origin: 23,
    destination: formModel.city.id,
    weight: 100 * _.size(cart.value),
    courier: formModel.courier.code,
});
watch(formModel.courier, (valueX) => {
    shipModel.courier = valueX.code;
    if (valueX.code) {
        watch([formModel.city], ([valueY]) => {
            shipModel.destination = valueY.id;
            shipModel.post(route("checkout.index"), {
                onSuccess: () => {
                    if (rajaongkir.value.status.code == 200) {
                        formModel.courier.service = "";
                        formModel.courier.name = newCost.value.description;
                        formModel.courier.etd = newCost.value.cost[0].etd;
                        formModel.courier.cost = newCost.value.cost[0].value;
                        shippingPriceRef.value = newCost.value.cost[0].value;
                    }
                },
            });
        });
    }
    if (valueX.cost) {
        shippingPriceRef.value = valueX.cost;
    }

    if (valueX.service) {
        watch([formModel.courier], ([valueX]) => {
            shipModel.courier = valueX.code;
            shipModel.post(route("checkout.index"));
        });
    }
    shipModel.post(route("checkout.index"));
});

function placeOrder() {
    const orderModel = useForm({
        ...shipModel,
        ...formModel,
        ...{
            total_price: totalPriceRef.value,
            cart: cart.value,
        },
    });
    formRef.value?.validate((errors) => {
        if (!errors) {
            let statusMessage = message.create(`Placing Your Order...`, {
                type: "loading",
                duration: 0,
            });

            orderModel.post(route("checkout.order"), {
                onFinish: () => {
                    statusMessage.destroy();
                },
                onSuccess: (page) => {
                    message.success(page.props.flash.success);
                    // formModel.reset();
                },
                onError: (errors) => {
                    for (const e in errors) {
                        message.error(errors[e], {
                            duration: 2500,
                        });
                    }
                },
            });
        } else {
            errors.forEach((item) => {
                message.error(item[0].message);
            });
        }
    });
}
</script>
