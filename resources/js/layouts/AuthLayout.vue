<template>
    <n-layout class="!font-montserrat">
        <n-layout-header class="!h-16 !bg-primary-500">
            <auth-header></auth-header>
        </n-layout-header>
        <n-layout-content content-style="padding: 20px">
            <slot />
        </n-layout-content>
        <n-layout-footer></n-layout-footer>
    </n-layout>
</template>
<script setup></script>

<style scoped></style>
