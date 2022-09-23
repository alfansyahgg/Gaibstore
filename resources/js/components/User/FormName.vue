<template>
    <n-form-item
        ref="formNameRef"
        label="Name"
        :path="path"
        :required="rule.required"
    >
        <n-input
            v-model:value="value"
            placeholder="Enter user name..."
            show-count
            @keydown.enter.prevent
        />
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    name: {
        type: String,
        default: null,
    },
    path: {
        type: String,
        default: "name",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:name"]);
const value = computed({
    get() {
        return props.name;
    },
    set(value) {
        emit("update:name", value);
    },
});

// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "User Name Cannot Be Empty!",
};

defineExpose({
    rule,
});
</script>
