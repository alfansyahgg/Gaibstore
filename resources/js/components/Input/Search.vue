<template>
    <n-input v-model:value="value" :placeholder="placeholder">
        <template #suffix>
            <n-icon :component="Search" />
        </template>
    </n-input>
</template>
<script setup>
import { Search } from "@vicons/ionicons5";

const props = defineProps({
    search: {
        type: String,
        default: null,
    },
    placeholder: {
        type: String,
        default: "Search...",
    },
});
const emit = defineEmits(["update:search"]);
const value = computed({
    get() {
        return props.search;
    },
    set(value) {
        emit("update:search", value);
    },
});
</script>
