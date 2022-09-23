<template>
    <div class="wrapper">
        <page-landing-carousel></page-landing-carousel>
        <page-landing-category></page-landing-category>
        <page-landing-product></page-landing-product>
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
const page = inject("$page")
console.log(page.value.props)
</script>