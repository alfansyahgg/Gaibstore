<template>
    <n-form-item
        ref="formBrandRef"
        label="Brand"
        :path="path"
        :required="rule.required"
    >
        <n-input
            v-model:value="value"
            placeholder="Enter product brand..."
            show-count
            @keydown.enter.prevent
        />
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    brand: {
        type: String,
        default: null,
    },
    path: {
        type: String,
        default: "brand",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:brand"]);
const value = computed({
    get() {
        return props.brand;
    },
    set(value) {
        emit("update:brand", value);
    },
});

// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "Product brand Cannot Be Empty!",
};

defineExpose({
    rule,
});
</script>
