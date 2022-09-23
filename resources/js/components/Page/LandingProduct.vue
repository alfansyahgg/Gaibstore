<template>
    <div class="products py-24 bg-carousel">
        <page-section-title>
            <template #title>Featured Products</template>
            <template #desc>
                Reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non
                proident.</template
            >
        </page-section-title>
        <div class="items px-8 mt-4">
            <page-product-item></page-product-item>
        </div>
    </div>
</template>
<script setup>
const srcList = [
    {
        id: 1,
        image: "products/category_img_01.jpg",
        label: "Watches",
        key: "watches",
    },
    {
        id: 2,
        image: "products/category_img_02.jpg",
        label: "Shoes",
        key: "shoes",
    },
    {
        id: 3,
        image: "products/category_img_03.jpg",
        label: "Accessories",
        key: "accessories",
    },
];
</script>