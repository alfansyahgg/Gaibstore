<template>
    <n-grid
        :x-gap="10"
        :y-gap="14"
        cols="1 400:2 640:3 800:3"
        class="grid-container !my-8"
    >
        <n-grid-item v-for="src in data" :key="src.id">
            <n-card hoverable>
                <template #cover>
                    <n-image
                        lazy
                        :intersection-observer-options="{
                            root: '.grid-container',
                        }"
                        width="125"
                        height="100"
                        object-fit="cover"
                        :src="src.media[0].preview_url"
                    ></n-image>
                </template>
                <n-space vertical>
                    <n-space justify="space-between" class="!py-1">
                        <h1 class="font-bold text-2xl">
                            {{ src.name }}
                        </h1>
                        <p class="text-gray-500">
                            Rp. {{ src.price.toLocaleString("id-ID") }}
                        </p>
                    </n-space>
                    <base-link
                        :href="$route('welcome.detail', { product: src.id })"
                    >
                        <n-button class="!w-full !mb-2" type="primary">
                            See Product
                        </n-button>
                    </base-link>
                </n-space>
            </n-card>
        </n-grid-item>
    </n-grid>
</template>
<script setup>
import { request } from "@/helpers";
import { Cart, Eye } from "@vicons/ionicons5";

// utils
const shop = computed(() => inject("$page").value.props.shop_item);
const data = computed(() => shop.value.data);
</script>
