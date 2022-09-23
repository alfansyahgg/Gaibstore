<template>
    <n-form-item ref="formSizeRef" label="Size" :path="path">
        <n-select
            v-model:value="value"
            filterable
            multiple
            tag
            placeholder="Input, press enter to create tag"
            :show-arrow="false"
            :show="false"
        />
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    size: {
        type: String,
        default: null,
    },
    path: {
        type: String,
        default: "size",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:size"]);
const value = computed({
    get() {
        return props.size;
    },
    set(value) {
        emit("update:size", value);
    },
});
// rule
const rule = {
    trigger: ["input", "blur"],
    required: false,
};
defineExpose({
    rule,
});
</script>
