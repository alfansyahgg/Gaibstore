<template>
    <n-grid :x-gap="10" :y-gap="8" cols="1 400:4 640:3">
        <n-grid-item v-for="src in srcList" :key="src.id">
            <n-space vertical align="center">
                <n-image
                    width="300"
                    :src="getImage(src.image)"
                    class="!rounded-full"
                />
                <p class="text-xl font-semibold">{{ src.label }}</p>
                <n-button type="success" size="large"> Shop Now </n-button>
            </n-space>
        </n-grid-item>
    </n-grid>
</template>
<script setup>
import { Images } from "@vicons/ionicons5";
const srcList = [
    {
        id: 1,
        image: "categories/category_img_01.jpg",
        label: "Watches",
        key: "watches",
    },
    {
        id: 2,
        image: "categories/category_img_02.jpg",
        label: "Shoes",
        key: "shoes",
    },
    {
        id: 3,
        image: "categories/category_img_03.jpg",
        label: "Accessories",
        key: "accessories",
    },
];
function getImage(image) {
    return new URL(`../../../images/${image}`, import.meta.url).href;
}
</script>

<style scoped>
@media only screen and (max-width: 640px) {
}
</style>