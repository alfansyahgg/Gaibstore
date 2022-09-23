<template>
    <n-layout position="absolute">
        <n-layout-header
            class="!h-20 !bg-primary-500 !flex !items-center !px-8"
        >
            <dashboard-header></dashboard-header>
        </n-layout-header>
        <n-layout has-sider class="!top-20" position="absolute">
            <n-layout-sider
                content-style="padding: 20px"
                collapse-mode="width"
                :collapsed-width="100"
                :width="240"
                :collapsed="collapsed"
                show-trigger
                @collapse="collapsed = true"
                @expand="collapsed = false"
            >
                <dashboard-sider :collapsed="collapsed"></dashboard-sider>
            </n-layout-sider>
            <n-layout class="!bg-gray-100" content-style="padding: 20px">
                <slot />
            </n-layout>
        </n-layout>
    </n-layout>
</template>
<script setup>
const collapsed = ref(true);
</script>