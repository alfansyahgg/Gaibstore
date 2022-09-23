<template>
    <div class="side">
        <h3 class="text-3xl">Categories</h3>
        <n-menu
            class="!py-8"
            :root-indent="0"
            :indent="0"
            :options="menuOptions"
            :theme-overrides="menuTheme"
        />
    </div>
</template>
<script setup>
import { NIcon } from "naive-ui";
import {
    BookOutline as BookIcon,
    PersonOutline as PersonIcon,
    WineOutline as WineIcon,
} from "@vicons/ionicons5";
import { repeat } from "seemly";
const { theme } = inject("$theme");
function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}

const menuOptions = [
    {
        label: "Gender",
        key: "gender",
        children: [
            {
                label: "Men",
                key: "men",
            },
            {
                label: "Women",
                key: "women",
            },
        ],
    },
    {
        label: "Sale",
        key: "sale",
        children: [
            {
                label: "Sport",
                key: "sport",
            },
            {
                label: "Luxury",
                key: "luxury",
            },
        ],
    },
    {
        label: "Product",
        key: "product",
        children: [
            {
                label: "Bag",
                key: "bag",
            },
            {
                label: "Sweather",
                key: "sweather",
            },
            {
                label: "Sweather",
                key: "Sunglass",
            },
        ],
    },
];

const menuTheme = {
    fontSize: "18px",
    itemColorHover: "#fff",
    itemColorActive: "#fff",
    itemColorActiveHover: "#fff",
    itemTextColorHover: theme.colors?.primary[500],
};
</script>
