<template>
    <n-layout>
        <n-layout-header class="!p-8 !bg-gray-100">
            <n-space justify="space-between" align="center">
                <h3 class="!text-primary-500 text-xl">
                    <slot name="headerName" />
                </h3>
                <div class="flex gap-x-2">
                    <slot name="headerButton" />
                </div>
            </n-space>
        </n-layout-header>
        <n-layout-content class="!p-8 !rounded-3xl">
            <slot name="content" />
        </n-layout-content>
        <n-layout-footer>
            <slot name="footer" />
        </n-layout-footer>
    </n-layout>
</template>