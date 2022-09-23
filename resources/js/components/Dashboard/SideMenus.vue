<template>
    <n-menu
        bordered
        :options="menuOptions"
        :collapsed="collapsed"
        :collapsed-width="64"
        :collapsed-icon-size="22"
        :theme-overrides="menuTheme"
    />
    <modal-logout v-model:logModal="logModalRef"></modal-logout>
</template>

<script setup>
import { NIcon } from "naive-ui";
import {
    HomeOutline,
    PricetagOutline,
    CartOutline,
    PeopleOutline,
    ClipboardOutline,
    ExitOutline,
} from "@vicons/ionicons5";
import { Link } from "@inertiajs/inertia-vue3";

// ref
const logModalRef = ref(false);

// utils
const props = defineProps(["collapsed"]);
const route = inject("$route");
const { theme } = inject("$theme");

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}

const menuOptions = [
    {
        label: () =>
            h(
                Link,
                {
                    href: route("dashboard"),
                },
                {
                    default: () => "Dashboard",
                }
            ),
        key: "dashboard",
        icon: renderIcon(HomeOutline),
    },
    {
        label: () =>
            h(
                Link,
                {
                    href: route("product.index"),
                },
                {
                    default: () => "Products",
                }
            ),
        key: "products",
        icon: renderIcon(CartOutline),
    },
    {
        label: () =>
            h(
                Link,
                {
                    href: route("category.index"),
                },
                {
                    default: () => "Categories",
                }
            ),
        key: "categories",
        icon: renderIcon(PricetagOutline),
    },
    {
        label: () =>
            h(
                Link,
                {
                    href: route("user.index"),
                },
                {
                    default: () => "Users",
                }
            ),
        key: "users",
        icon: renderIcon(PeopleOutline),
    },
    {
        label: () =>
            h(
                Link,
                {
                    href: route("order.index"),
                },
                {
                    default: () => "Orders",
                }
            ),
        key: "orders",
        icon: renderIcon(ClipboardOutline),
    },
    {
        type: "divider",
        key: "divider-1",
        props: {
            style: {
                width: "100%",
            },
        },
    },
    {
        label: () =>
            h(
                "a",
                {
                    onClick: () => (logModalRef.value = true),
                },
                {
                    default: () => "Logout",
                }
            ),
        key: "logout",
        icon: renderIcon(ExitOutline),
    },
];

const menuTheme = {
    itemHeight: "60px",
    itemIconColor: theme.colors?.primary[500],
    itemTextColor: theme.colors?.primary[500],
    itemIconColorCollapsed: theme.colors?.primary[500],
    itemColorActive: "rgba(99, 226, 183, 0.15)",
    itemColorActive: "rgba(99, 226, 183, 0.15)",
    itemIconColorHover: theme.colors?.primary[600],
    itemIconColorActive: theme.colors?.primary[600],
    itemIconColorActiveHover: theme.colors?.primary[600],
    itemIconColorActiveHover: theme.colors?.primary[600],
    itemTextColorHover: theme.colors?.primary[600],
    itemTextColorActive: theme.colors?.primary[600],
    itemTextColorActiveHover: theme.colors?.primary[600],
    itemColorActiveHover: "rgba(255, 255, 255, 0.09)",
};
</script>
