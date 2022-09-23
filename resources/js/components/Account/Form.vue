<template>
    <n-form ref="formRef" :model="formModel" :rules="formRules">
        <account-form-password
            ref="formOldPasswordRef"
            v-model:password="formModel.password"
            path="password.old"
            label="Old Password"
            placeholder="Enter old password..."
            message="Old Password cannot be empty..."
            psw="old"
        ></account-form-password>
        <account-form-password
            ref="formNewPasswordRef"
            v-model:password="formModel.password"
            path="password.new"
            label="New Password"
            placeholder="Enter new password..."
            message="New Password cannot be empty..."
            psw="new"
        ></account-form-password>
        <account-form-password
            ref="formConfirmPasswordRef"
            v-model:password="formModel.password"
            path="password.confirm"
            label="Confirm New Password"
            placeholder="Enter confirm new password..."
            message=""
            :validator="validatorConfirm"
            psw="confirm"
        ></account-form-password>
    </n-form>
</template>
<script setup>
// ref
const formRef = ref(null);
const formEmailRef = ref(null);
const formOldPasswordRef = ref(null);
const formNewPasswordRef = ref(null);
const formConfirmPasswordRef = ref(null);

// props
const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({}),
    },
    photo: {
        type: Boolean,
        default: true,
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
        password: {
            old: formOldPasswordRef.value?.rule,
            new: formNewPasswordRef.value?.rule,
            confirm: formConfirmPasswordRef.value?.rule,
        },
    };
});

// const validatorConfirm = {
//     validator: validatePasswordSame,
//     message: "Password is not same as re-entered password!",
//     trigger: ["blur", "password-input"],
// };

// function validatePasswordStartWith(rule, value) {
//     return (
//         !!modelRef.value.password &&
//         modelRef.value.password.startsWith(value) &&
//         modelRef.value.password.length >= value.length
//     );
// }
// function validatePasswordSame(rule, value) {
//     return value === formModel.value.password.new;
// }

// expose
function validate(callback) {
    formRef.value?.validate(callback);
}

defineExpose({
    validate,
});
</script>
