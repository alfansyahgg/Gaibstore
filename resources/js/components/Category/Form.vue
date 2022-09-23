<template>
    <n-form ref="formRef" :model="formModel" :rules="formRules">
        <category-form-name
            ref="formNameRef"
            v-model:name="formModel.name"
            path="name"
        ></category-form-name>
        <category-form-desc
            ref="formDescRef"
            v-model:desc="formModel.desc"
            path="desc"
        ></category-form-desc>
    </n-form>
</template>
<script setup>
// ref
const formRef = ref(null);
const formNameRef = ref(null);
const formDescRef = ref(null);

// props
const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({}),
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
        desc: formDescRef.value?.rule,
    };
});

function validate(callback) {
    formRef.value?.validate(callback);
}

defineExpose({
    validate,
});
</script>