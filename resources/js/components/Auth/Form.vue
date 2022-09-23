<template>
    <n-form ref="formRef" :rules="formRules" :model="formModel">
        <auth-form-email
            ref="formEmailRef"
            v-model:email="formModel.email"
            path="email"
        />
        <auth-form-password
            ref="formPasswordRef"
            v-model:password="formModel.password"
            path="password"
        />
    </n-form>
</template>
<script setup>
import { useMessage } from "naive-ui";

const formRef = ref(null);
const formEmailRef = ref(null);
const formPasswordRef = ref(null);
const formRememberRef = ref(null);
const message = useMessage();

const props = defineProps({
    form: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(["update:form"]);

const formModel = computed({
    get() {
        return props.form;
    },
    set(value) {
        emit("update:form", value);
    },
});

const formRules = computed(() => {
    return {
        email: formEmailRef.value?.rule,
        password: formPasswordRef.value?.rule,
    };
});

function validate(callback) {
    formRef.value?.validate(callback);
}

defineExpose({
    validate,
});
</script>