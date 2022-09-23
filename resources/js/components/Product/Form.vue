<template>
    <n-form ref="formRef" :model="formModel" :rules="formRules">
        <product-form-name
            ref="formNameRef"
            v-model:name="formModel.name"
            path="name"
        ></product-form-name>
        <product-form-brand
            ref="formBrandRef"
            v-model:brand="formModel.brand"
            path="brand"
        ></product-form-brand>
        <product-form-desc
            ref="formDescRef"
            v-model:desc="formModel.desc"
            path="desc"
        ></product-form-desc>
        <product-form-variant
            ref="formVariantRef"
            v-model:variant="formModel.variant"
            path="variant"
        ></product-form-variant>
        <product-form-price
            ref="formPriceRef"
            v-model:price="formModel.price"
            path="price"
        ></product-form-price>
        <product-form-category
            ref="formCategoryRef"
            v-model:category="formModel.category"
            path="category"
            :data="category"
        ></product-form-category>
    </n-form>
</template>
<script setup>
// ref
const formRef = ref(null);
const formNameRef = ref(null);
const formDescRef = ref(null);
const formPriceRef = ref(null);
const formCategoryRef = ref(null);
const formVariantRef = ref(null);

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
        desc: formDescRef.value?.rule,
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
