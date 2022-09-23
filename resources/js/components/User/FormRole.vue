<template>
    <n-form-item
        ref="formRoleRef"
        label="Role"
        :path="path"
        :required="rule.required"
    >
        <n-select
            v-model:value="value"
            :options="options"
            :consistent-menu-width="false"
        />
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    role: {
        type: String,
        default: null,
    },
    path: {
        type: String,
        default: "role",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:role"]);
const value = computed({
    get() {
        return props.role;
    },
    set(value) {
        emit("update:role", value);
    },
});

// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "User Role Cannot Be Empty!",
};

// role options
const options = [
    {
        label: "Super Admin",
        value: "admin",
    },
    {
        label: "Supervisor",
        value: "supervisor",
    },
    {
        label: "Reguler",
        value: "reguler",
    },
];

defineExpose({
    rule,
});
</script>