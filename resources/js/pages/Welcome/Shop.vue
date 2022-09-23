<template>
    <div class="wrapper">
        <n-layout has-sider class="!px-20 !py-8">
            <n-layout-sider>
                <page-shop-sider></page-shop-sider>
            </n-layout-sider>
            <n-layout>
                <page-shop-search v-model:search="searchRef"></page-shop-search>
                <page-shop-item></page-shop-item>
            </n-layout>
        </n-layout>
        <page-landing-brand></page-landing-brand>
        <page-landing-bottom></page-landing-bottom>
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
// ref
const searchRef = ref(null);

// utils
const page = inject("$page").value.props;
</script>
