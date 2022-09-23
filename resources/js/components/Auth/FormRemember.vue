<template>
    <n-form-item path="remember">
        <n-checkbox v-model:checked="rememberModel"> Remember Me </n-checkbox>
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    remember: {
        type: String,
        default: () => {},
    },
});

const emit = defineEmits(["update:remember"]);

const rememberModel = computed({
    get() {
        return props.remember;
    },
    set(value) {
        emit("update:remember", value);
    },
});
</script>