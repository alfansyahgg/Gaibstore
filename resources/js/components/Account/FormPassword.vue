<template>
    <n-form-item :label="label" :path="path">
        <n-input
            v-model:value="passwordPsw"
            :placeholder="placeholder"
            @keydown.enter.prevent
            type="password"
            show-password-on="click"
            :maxlength="10"
        />
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    password: {
        type: String,
        default: null,
    },
    path: {
        type: String,
        default: "password",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    label: {
        type: String,
        default: "Password",
    },
    placeholder: {
        type: String,
        default: "Enter Password....",
    },
    message: {
        type: String,
        default: "",
    },
    validator: {
        type: Object,
        default: {
            validator: function () {},
            message: "",
            trigger: ["input", "blur"],
        },
    },
    psw: {
        type: String,
        default: "",
    },
});
const emit = defineEmits(["update:password"]);
const value = computed({
    get() {
        return props.password;
    },
    set(value) {
        emit("update:password", value);
    },
});
const passwordPsw = computed({
    get() {
        if (props.psw == "old") {
            return value.value.old;
        } else if (props.psw == "new") {
            return value.value.new;
        } else {
            return value.value.confirm;
        }
    },
    set(newValue) {
        if (props.psw == "old") {
            value.value.old = newValue;
        } else if (props.psw == "new") {
            value.value.new = newValue;
        } else {
            value.value.confirm = newValue;
        }
    },
});
// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: props.message,
};

defineExpose({
    rule,
});
</script>
