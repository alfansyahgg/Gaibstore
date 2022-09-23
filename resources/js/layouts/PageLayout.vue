<template>
    <!-- Layout -->
    <n-layout position="absolute">
        <!-- Header -->
        <n-layout-header class="!px-8" style="height: 5rem !important">
            <page-header></page-header>
        </n-layout-header>
        <!-- Content -->
        <n-layout position="absolute" class="!top-20" :native-scrollbar="false">
            <n-layout-content>
                <slot />
            </n-layout-content>
            <!-- Footer -->
            <n-layout-footer style="height: 3rem !important">
                <page-landing-footer></page-landing-footer>
            </n-layout-footer>
        </n-layout>
    </n-layout>
</template>
