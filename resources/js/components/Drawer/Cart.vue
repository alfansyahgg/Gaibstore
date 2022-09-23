<template>
    <n-drawer v-model:show="drawer" class="!w-96" placement="right">
        <n-drawer-content title="My Cart" closable>
            <div class="flex flex-col h-full">
                <n-scrollbar>
                    <div
                        v-for="cr in cart"
                        :key="cr.id"
                        class="flex gap-2 border-b pb-2 mb-4"
                    >
                        <n-avatar
                            class="!self-center"
                            :size="48"
                            :src="cr.preview"
                        />
                        <div class="flex flex-col w-2/6">
                            <h3 class="font-semibold">{{ cr.name }}</h3>
                            <p class="text-xs">
                                {{ cr.color }} - Size {{ cr.size }}
                            </p>
                            <p class="text-xs">
                                Rp. {{ cr.price.toLocaleString("id") }}
                            </p>
                        </div>
                        <div class="flex flex-col w-2/6">
                            <h3 class="font-semibold">Quantity</h3>
                            <n-space>
                                <n-input-number
                                    :ref="`${cr.id}Ref`"
                                    v-model:value="cr.quantity"
                                    size="small"
                                    :min="1"
                                    :loading="qtyLoading"
                                    @update:value="upQuantity(cr)"
                                />
                            </n-space>
                        </div>
                        <div class="flex w-1/6">
                            <n-button
                                size="large"
                                class="!h-full"
                                type="error"
                                @click="deleteFromCart(cr.id)"
                            >
                                <template #icon>
                                    <n-icon>
                                        <trash></trash>
                                    </n-icon>
                                </template>
                            </n-button>
                        </div>
                    </div>
                </n-scrollbar>
            </div>
            <template #footer>
                <n-space vertical class="!w-full">
                    <h3 class="font-semibold text-right">
                        Total : Rp. {{ totalPriceRef.toLocaleString("id") }}
                    </h3>
                    <base-link
                        v-if="cartSize > 0"
                        :href="$route('checkout.index')"
                    >
                        <n-button type="primary" class="!w-full !self-end">
                            Buy Now
                        </n-button>
                    </base-link>
                </n-space>
            </template>
        </n-drawer-content>
    </n-drawer>
</template>
<script setup>
import { Inertia } from "@inertiajs/inertia";
import { Trash } from "@vicons/ionicons5";
import { useMessage } from "naive-ui";
// utils
const route = inject("$route");
const message = useMessage();

// props
const props = defineProps({
    drawer: {
        type: Boolean,
        default: false,
    },
    cart: {
        type: Object,
        default: () => {},
    },
});

// emit
const emit = defineEmits(["update:drawer", "update:cart"]);

// model
const drawer = computed({
    get() {
        return props.drawer;
    },
    set(newVal) {
        emit("update:drawer", newVal);
    },
});
const cart = computed({
    get() {
        return props.cart;
    },
    set(newVal) {
        emit("update:cart", newVal);
    },
});

console.log(cart.value);

const cartSize = computed(() => Object.keys(cart.value).length);

// ref
const qtyLoading = ref(false);
const priceRef = computed(() => _.map(cart.value, (x) => x.price * x.quantity));
const totalPriceRef = computed(() => _.sum(priceRef.value));

// function
function deleteFromCart(variant_id) {
    Inertia.post(route("welcome.delete-from-cart"), {
        data: variant_id,
        onFinish: () => {
            message.create("finished");
        },
    });
}

function upQuantity(val) {
    qtyLoading.value = true;
    Inertia.post(
        route("welcome.add-to-cart"),
        {
            data: val,
        },
        {
            onFinish: (visit) => {
                qtyLoading.value = false;
            },
        }
    );
}
</script>
