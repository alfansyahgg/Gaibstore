<template>
    <div class="flex gap-x-2">
        <n-input v-model:value="value" placeholder="Find Item">
            <template #prefix>
                <n-icon :component="SearchOutline" />
            </template>
        </n-input>
        <n-button type="info" size="medium" @click="search"> Search </n-button>
    </div>
</template>
<script setup>
import { Inertia } from "@inertiajs/inertia";
import { SearchOutline } from "@vicons/ionicons5";

// props
const props = defineProps({
    search: {
        type: String,
        default: () => "",
    },
});

// emit
const emit = defineEmits(["update:search"]);

// model
const value = computed({
    get() {
        return props.search;
    },
    set(newValue) {
        emit("update:search", newValue);
    },
});

function search() {
    Inertia.visit(route("welcome.shop"), {
        data: { search: value.value },
        preserveState: true,
    });
}
</script>
