<template>
    <div class="wrapper">
        <page-landing-about></page-landing-about>
        <page-landing-service></page-landing-service>
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