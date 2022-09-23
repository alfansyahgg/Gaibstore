<template>
    <n-form-item
        ref="formStatusRef"
        label="Status"
        :path="path"
        :required="rule.required"
    >
        <n-switch v-model:value="value" :checked-value="1" :unchecked-value="0">
            <template #checked> Active </template>
            <template #unchecked> Inactive </template>
        </n-switch>
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    active: {
        type: Number,
        default: 0,
    },
    path: {
        type: String,
        default: "active",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:active"]);
const value = computed({
    get() {
        return props.active;
    },
    set(value) {
        emit("update:active", value);
    },
});

// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "User status Cannot Be Empty!",
};

// role options
const options = [
    {
        label: "Active",
        value: "1",
    },
    {
        label: "Inactive",
        value: "0",
    },
];

function handleUpdateValue(switchVal) {
    value.value = switchVal;
}

defineExpose({
    rule,
});
</script>
