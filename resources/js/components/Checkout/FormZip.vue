<template>
    <n-form-item
        ref="formZipRef"
        label="Zip Code"
        :path="path"
        :required="rule.required"
    >
        <n-input
            v-model:value="value"
            placeholder="Enter zip code..."
            :allow-input="onlyAllowNumber"
            show-count
            :max-length="5"
            @keydown.enter.prevent
        />
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    zip: {
        type: String,
        default: null,
    },
    path: {
        type: String,
        default: "zip",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:zip"]);
const value = computed({
    get() {
        return props.zip;
    },
    set(value) {
        emit("update:zip", value);
    },
});

// only allow number
const onlyAllowNumber = (value) => !value || /^\d+$/.test(value);
// rule
const rule = {
    trigger: ["input", "blur"],
    required: false,
    message: "Zip Code Cannot Be Empty!",
};

defineExpose({
    rule,
});
</script>
