<template>
    <n-form-item ref="formPasswordRef" label="Password" :path="path">
        <n-input
            v-model:value="value"
            placeholder="Enter user password to change..."
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
</script>
