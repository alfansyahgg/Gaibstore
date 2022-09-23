<template>
    <n-grid :x-gap="10" :y-gap="8" :cols="4">
        <n-grid-item
            v-for="(sv, index) in services"
            :key="index"
        >
            <n-space
                class="group !shadow-2xl !py-12 hover:!bg-primary-500 !cursor-pointer"
                justify="center"
                vertical
            >
                <div class="image flex justify-center">
                    <n-icon
                        :size="60"
                        class="!text-primary-500 group-hover:!text-white"
                    >
                        <component :is="sv.icon"></component>
                    </n-icon>
                </div>
                <h3
                    class="text-2xl py-4 font-semibold text-center group-hover:!text-white"
                >
                    {{
                        sv.text
                    }}
                </h3>
            </n-space>
        </n-grid-item>
    </n-grid>
</template>
<script setup>
import {
    Train,
    SwapHorizontal,
    ThumbsUp,
    Chatbubbles,
} from "@vicons/ionicons5";

const services = [
    {
        icon: h(Train, null),
        text: "Delivery Services",
    },
    {
        icon: h(SwapHorizontal, null),
        text: "Shipping & Return",
    },
    {
        icon: h(ThumbsUp, null),
        text: "Good Price",
    },
    {
        icon: h(Chatbubbles, null),
        text: "24 Hours Service",
    },
];
</script>