<template>
    <n-form-item
        ref="formFnameRef"
        label="First Name"
        :path="path"
        :required="rule.required"
    >
        <n-input
            v-model:value="value"
            placeholder="Enter first name..."
            show-count
            @keydown.enter.prevent
        />
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    fname: {
        type: String,
        default: null,
    },
    path: {
        type: String,
        default: "fname",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:fname"]);
const value = computed({
    get() {
        return props.fname;
    },
    set(value) {
        emit("update:fname", value);
    },
});

// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "First Name Cannot Be Empty!",
};

defineExpose({
    rule,
});
</script>
