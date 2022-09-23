<template>
    <n-form ref="formRef" :model="formModel" :rules="formRules">
        <user-form-email
            ref="formEmailRef"
            v-model:email="formModel.email"
            path="email"
        ></user-form-email>
        <user-form-role
            ref="formRoleRef"
            v-model:role="formModel.role"
            path="role"
        ></user-form-role>
        <user-form-status
            ref="formStatusRef"
            v-model:active="formModel.active"
            path="status"
        ></user-form-status>
        <user-form-password
            ref="formPasswordRef"
            v-model:password="formModel.password"
            path="password"
        ></user-form-password>
    </n-form>
</template>
<script setup>
// ref
const formRef = ref(null);
const formNameRef = ref(null);
const formEmailRef = ref(null);
const formRoleRef = ref(null);
const formStatusRef = ref(null);
const formPasswordRef = ref(null);

// props
const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({}),
    },
    category: {
        type: Array,
        default: () => [],
    },
});
const emit = defineEmits(["update:modelValue"]);
const formModel = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});

// rules
const formRules = computed(() => {
    return {
        name: formNameRef.value?.rule,
    };
});

// expose
function validate(callback) {
    formRef.value?.validate(callback);
}

defineExpose({
    validate,
});
</script>
