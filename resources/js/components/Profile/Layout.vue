<template>
    <n-layout has-sider class="!h-[calc(100vh_-_8rem)]">
        <n-layout-sider bordered>
            <n-menu :options="menuOptions" class="!w-64" />
        </n-layout-sider>
        <n-layout>
            <n-layout-content
                content-style="padding: 24px;"
                class="!bg-gray-100 !h-full"
            >
                <slot></slot>
            </n-layout-content>
        </n-layout>
    </n-layout>
</template>
<script setup>
import { defineComponent, h } from "vue";
import { NIcon, useMessage } from "naive-ui";
import {
    PersonOutline as PersonIcon,
    Key as KeyIcon,
    CardOutline as CardIcon,
    ExitOutline as ExitIcon,
    NewspaperOutline as OrderHistoryIcon,
} from "@vicons/ionicons5";
import { Link } from "@inertiajs/inertia-vue3";

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}

//utils
const message = useMessage();
const route = inject("$route");

// options
const menuOptions = [
    {
        label: () =>
            h(
                Link,
                {
                    href: route("profile.index"),
                },
                {
                    default: () => "My Profile",
                }
            ),
        key: "my-profile",
        icon: renderIcon(PersonIcon),
    },
    {
        label: () =>
            h(
                Link,
                {
                    href: route("profile.purchase"),
                },
                {
                    default: () => "My Orders",
                }
            ),
        key: "my-order",
        icon: renderIcon(OrderHistoryIcon),
    },
    {
        label: () =>
            h(
                Link,
                {
                    href: route("profile.account"),
                },
                {
                    default: () => "Account Security",
                }
            ),
        key: "account-security",
        icon: renderIcon(KeyIcon),
    },
    {
        type: "divider",
    },
    {
        label: () =>
            h(
                Link,
                {
                    href: route("auth.logout"),
                    method: "post",
                },
                {
                    default: () => "Logout",
                }
            ),
        key: "logout",
        icon: renderIcon(ExitIcon),
    },
];
const defaultExpandedKeys = ["dance-dance-dance", "food"];
function handleUpdateExpandedKeys(value) {
    message.info("[onUpdate:expandedKeys]: " + JSON.stringify(value));
}
</script>
