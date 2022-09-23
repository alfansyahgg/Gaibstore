<template>
    <div class="bottom p-8 !bg-primary-900">
        <n-layout>
            <n-layout-content>
                <n-grid
                    class="!bg-primary-900"
                    :x-gap="10"
                    :y-gap="8"
                    :cols="'1 400:4 640:'+menus.length"
                >
                    <n-grid-item v-for="(menu, index) in menus" :key="index">
                        <n-list class="!bg-primary-900">
                            <template #header>
                                <h3
                                    class="text-white font-bold text-2xl"
                                    :class="{
                                        'text-primary-500': menu.primary,
                                    }"
                                >
                                    {{ menu.title }}
                                </h3>
                            </template>
                            <n-list-item>
                                <n-space
                                    vertical
                                    v-for="(li, index) in menu.list"
                                    :key="index"
                                >
                                    <base-link
                                        class="!text-white"
                                        :class="{
                                            'hover:!text-primary-500':
                                                li.href != null,
                                        }"
                                    >
                                        <n-space>
                                            <n-icon
                                                v-if="li.icon != null"
                                                :size="25"
                                            >
                                                <component
                                                    :is="li.icon"
                                                ></component>
                                            </n-icon>
                                            <p>
                                                {{ li.text }}
                                            </p>
                                        </n-space>
                                    </base-link>
                                </n-space>
                            </n-list-item>
                        </n-list>
                    </n-grid-item>
                </n-grid>
            </n-layout-content>
            <n-layout-footer class="!bg-primary-900">
                <div class="flex items-center justify-between">
                    <div class="flex gap-2 w-1/2">
                        <a href="https://www.facebook.com/alfansyahgg">
                            <div class="icon">
                                <n-icon color="#fff" :size="40">
                                    <logo-facebook></logo-facebook>
                                </n-icon>
                            </div>
                        </a>
                        <a href="https://www.facebook.com/alfansyahgg">
                            <div class="icon">
                                <n-icon color="#fff" :size="40">
                                    <logo-whatsapp></logo-whatsapp>
                                </n-icon>
                            </div>
                        </a>
                        <a href="https://www.instagram.com/alfansyahgg">
                            <div class="icon">
                                <n-icon color="#fff" :size="40">
                                    <logo-instagram></logo-instagram>
                                </n-icon>
                            </div>
                        </a>
                        <a href="https://www.twitter.com/AlfansyahNP">
                            <div class="icon">
                                <n-icon color="#fff" :size="40">
                                    <logo-twitter></logo-twitter>
                                </n-icon>
                            </div>
                        </a>
                    </div>
                    <div class="flex w-1/2"></div>
                </div>
            </n-layout-footer>
        </n-layout>
    </div>
</template>
<script setup>
import {
    Pin,
    Call,
    Mail,
    LogoFacebook,
    LogoWhatsapp,
    LogoInstagram,
    LogoTwitter,
} from "@vicons/ionicons5";
const route = inject("$route");
const menus = [
    {
        title: "Gaib Store",
        primary: true,
        list: [
            {
                icon: h(Pin, null),
                text: "123 Consectetur at ligula 10660",
                href: null,
            },
            {
                icon: h(Call, null),
                text: "010-020-0340",
                href: null,
            },
            {
                icon: h(Mail, null),
                text: "info@company.com",
                href: null,
            },
        ],
    },
    {
        title: "Products",
        primary: false,
        list: [
            {
                icon: null,
                text: "Luxury",
                href: "",
            },
            {
                icon: null,
                text: "Sportwear",
                href: "",
            },
            {
                icon: null,
                text: "Men's Shoes",
                href: "",
            },
            {
                icon: null,
                text: "Women's Shoes",
                href: "",
            },
            {
                icon: null,
                text: "Popular Dress",
                href: "",
            },
        ],
    },
    {
        title: "Further Info",
        primary: false,
        list: [
            {
                icon: null,
                text: "Home",
                href: "",
            },
            {
                icon: null,
                text: "About Us",
                href: "",
            },
            {
                icon: null,
                text: "Shop Location",
                href: "",
            },
            {
                icon: null,
                text: "FAQs",
                href: "",
            },
            {
                icon: null,
                text: "Contacts",
                href: "",
            },
        ],
    },
];
</script>
<style scoped>
.icon {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
}
</style>