<template>
    <n-form-item
        ref="formLnameRef"
        label="Last Name"
        :path="path"
        :required="rule.required"
    >
        <n-input
            v-model:value="value"
            placeholder="Enter last name..."
            show-count
            @keydown.enter.prevent
        />
    </n-form-item>
</template>
<script setup>
const props = defineProps({
    lname: {
        type: String,
        default: null,
    },
    path: {
        type: String,
        default: "lname",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:lname"]);
const value = computed({
    get() {
        return props.lname;
    },
    set(value) {
        emit("update:lname", value);
    },
});

// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "Last Name Cannot Be Empty!",
};

defineExpose({
    rule,
});
</script>
