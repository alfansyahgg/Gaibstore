<template>
    <n-form-item
        ref="formDescRef"
        :path="path"
        label="Description"
    >
        <n-input
            v-model:value="value"
            placeholder="Enter product description..."
            type="textarea"
            show-count
            @keydown.enter.prevent
        />
    </n-form-item>
</template>
<script setup>
const formDescRef = ref(null);
const props = defineProps({
    desc: {
        type: String,
        default: null,
    },
    path: {
        type: String,
        default: "desc",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:desc"]);
const value = computed({
    get() {
        return props.desc;
    },
    set(value) {
        emit("update:desc", value);
    },
});

// rule
const rule = {
    trigger: ["input", "blur"],
    required: false,
    message: "Product Desc Cannot Be Empty!",
};

defineExpose({
    rule,
});
</script>