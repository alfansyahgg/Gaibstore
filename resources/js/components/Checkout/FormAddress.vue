<template>
    <n-form-item
        ref="formAddressRef"
        label="Address"
        :path="path"
        :required="rule.required"
    >
        <n-input
            v-model:value="value"
            placeholder="Enter address..."
            show-count
            @keydown.enter.prevent
        />
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    address: {
        type: String,
        default: null,
    },
    path: {
        type: String,
        default: "address",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:address"]);
const value = computed({
    get() {
        return props.address;
    },
    set(value) {
        emit("update:address", value);
    },
});

// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "Address Cannot Be Empty!",
};

defineExpose({
    rule,
});
</script>
