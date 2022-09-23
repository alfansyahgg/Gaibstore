<template>
    <n-form-item
        ref="formEmailRef"
        label="Email"
        :path="path"
        :required="rule.required"
    >
        <n-input
            v-model:value="value"
            placeholder="Enter user email..."
            show-count
            @keydown.enter.prevent
        />
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    email: {
        type: String,
        default: null,
    },
    path: {
        type: String,
        default: "email",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:email"]);
const value = computed({
    get() {
        return props.email;
    },
    set(value) {
        emit("update:email", value);
    },
});

// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "User Email Cannot Be Empty!",
};

defineExpose({
    rule,
});
</script>
