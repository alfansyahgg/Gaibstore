<template>
    <n-form-item ref="formCategoryRef" label="Category" :path="path">
        <n-select
            v-model:value="value"
            multiple
            :options="props.data"
            :render-tag="renderTag"
            placeholder="Please select groups this contact belong to..."
            :consistent-menu-width="false"
        />
    </n-form-item>
</template>
<script setup>
import { NTag } from "naive-ui";
// ref
const formCategoryRef = ref(null);
const selectRef = ref(null);

const props = defineProps({
    category: {
        type: Array,
        default: () => [],
    },
    path: {
        type: String,
        default: "category",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Array,
        default: () => [],
    },
});
const emit = defineEmits(["update:category"]);
const value = computed({
    get() {
        return props.category;
    },
    set(value) {
        emit("update:category", value);
    },
});


// render-tag
const renderTag = ({ option, handleClose }) => {
    return h(
        NTag,
        {
            type: "primary",
            closable: true,
            onMousedown: (e) => {
                e.preventDefault();
            },
            onClose: (e) => {
                e.stopPropagation();
                handleClose();
            },
        },
        { default: () => option.label }
    );
};

</script>