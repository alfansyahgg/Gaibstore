<template>
    <div class="wrapper">
        <div
            class="product-detail py-24 flex flex-col sm:flex-row gap-2 px-4 sm:px-16 bg-carousel"
        >
            <div class="photos w-full sm:w-2/6 flex flex-col gap-1">
                <div class="w-full mx-auto">
                    <n-image :src="product.media[0].original_url" />
                </div>
                <n-carousel
                    slides-per-view="3"
                    :space-between="5"
                    :loop="true"
                    autoplay
                    draggable
                    class="!h-auto"
                >
                    <n-carousel-item
                        v-for="photo in product.media"
                        :key="photo.id"
                    >
                        <n-image :src="photo.original_url" />
                    </n-carousel-item>
                    <template #arrow="{ prev, next }">
                        <div class="custom-arrow">
                            <button
                                type="button"
                                class="curtom-arrow--left"
                                @click="prev"
                            >
                                <n-icon :size="20"><ArrowBack /></n-icon>
                            </button>
                            <button
                                type="button"
                                class="curtom-arrow--right"
                                @click="next"
                            >
                                <n-icon :size="20"><ArrowForward /></n-icon>
                            </button>
                        </div>
                    </template>
                </n-carousel>
            </div>
            <div class="desc w-full sm:w-4/6 h-1/2 p-8 bg-white">
                <h3 class="text-3xl font-semibold">{{ product.name }}</h3>
                <p class="py-4 text-xl">
                    Rp. {{ product.price.toLocaleString("id-ID") }}
                </p>
                <p class="py-4 text-xl"><b>Brand : </b> {{ product.brand }}</p>
                <p class="py-4 text-xl"><b>Description :</b></p>
                <p>
                    {{ product.desc }}
                </p>
                <p class="py-4 text-xl"><b>Select Variants :</b></p>
                <table-detail
                    v-model:columns="columns"
                    v-model:data="variants"
                    :rowProps="rowProps"
                    :rowClassName="rowClassName"
                    :theme="tableTheme"
                    :height="250"
                />
                <p class="py-4 text-xl"><b>Quantity :</b></p>
                <n-space vertical>
                    <n-input-number
                        v-model:value="quantityRef"
                        :max="selectVariant ? selectVariant.stock : 0"
                        :min="1"
                        size="medium"
                    />
                </n-space>

                <hr class="my-4" />

                <n-space class="!py-4">
                    <n-button type="warning" size="large" @click="null"
                        >Buy Now</n-button
                    >
                    <n-button type="warning" size="large" @click="addToCart"
                        >Add To Cart</n-button
                    >
                </n-space>
            </div>
        </div>
        <page-landing-category></page-landing-category>
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
import { ArrowBack, ArrowForward } from "@vicons/ionicons5";
import { NButton, useMessage } from "naive-ui";
import { request } from "@/helpers";
import { Inertia } from "@inertiajs/inertia";

// utils
const { _ } = window;
const page = inject("$page").value.props;
const product = computed(() => page.data.product);
const variants = product.value.variants;
const route = inject("$route");
const cart = computed(() => page.cart);
window.$message = useMessage();

// colors
const colors = _.map(variants, (item) => item.color);
const uniq_colors = _.uniq(colors);

// size
const sizes = _.map(variants, (item) => item.size);
const uniq_sizes = _.uniq(sizes);

// ref
const selectVariant = ref(null);
const quantityRef = ref(0);
const variantIndex = ref(null);
const columns = ref([
    {
        title: "Color",
        key: "color",
    },
    {
        title: "Size",
        key: "size",
        align: "center",
    },
    {
        title: "Stock",
        key: "stock",
        align: "center",
    },
    {
        title: "Price",
        key: "price",
        render(row) {
            return `Rp. ${product.value.price.toLocaleString("id")}`;
        },
    },
]);

// row props
const rowProps = (row) => {
    return {
        style: "cursor: pointer;",
        onClick: () => {
            variantIndex.value = row.id;
            selectVariant.value = row;
            quantityRef.value = 1;
        },
    };
};

// row class
const rowClassName = (row) => {
    if (variantIndex.value == row.id) {
        return "selected";
    }
    return "";
};

// theme
const tableTheme = computed({
    get() {
        return {
            tdColorHover: "rgba(215, 215, 215, 1)",
        };
    },
    set(newValue) {},
});

function addToCart() {
    if (!selectVariant.value) {
        window.$message.error("Please select a variant");
        return false;
    }
    const addToCart = {
        ...selectVariant.value,
        ...{
            quantity: quantityRef.value,
        },
    };
    request(
        "Adding to cart...",
        route("welcome.add-to-cart"),
        "post",
        addToCart,
        {
            onSuccess: (page) => {
                window.$message.success("Successfully added to cart!");
            },
            onError: (errors) => {
                for (const e in errors) {
                    window.$message.error(errors[e], {
                        duration: 2500,
                    });
                }
            },
        }
    );
}
</script>

<style scoped>
:deep(.selected td) {
    background-color: #4caf50 !important;
    color: white !important;
}
</style>
