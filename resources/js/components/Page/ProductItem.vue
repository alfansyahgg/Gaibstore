<template>
    <n-grid :x-gap="10" :y-gap="8" cols="1 400:4 640:3">
        <n-grid-item v-for="src in product_item" :key="src.id">
            <n-card size="small">
                <template #cover>
                    <n-image
                        width="150"
                        :src="src.media[0].original_url"
                        class="!mx-auto"
                    ></n-image>
                </template>
                <n-space justify="space-between" class="!py-2">
                    <n-rate readonly :default-value="5" />
                    <p class="text-gray-500">
                        Rp. {{ src.price.toLocaleString("id") }}
                    </p>
                </n-space>
                <h1 class="font-bold text-2xl">
                    {{ src.name }}
                </h1>
                <p class="text-lg font-light">
                    {{ src.desc }}
                </p>
                <n-space justify="end">
                    <base-link
                        :href="$route('welcome.detail', { product: src.id })"
                    >
                        <n-button type="primary"> See Product </n-button>
                    </base-link>
                </n-space>
            </n-card>
        </n-grid-item>
    </n-grid>
</template>
<script setup>
const product_item = computed(() => inject("$page").value.props.product_item);
</script>
