<template>
    <n-form-item
        :label="label"
        :label-props="{ class: 'font-medium' }"
        :required="rule.required"
        :path="path"
    >
        <input-phone
            v-model="value"
            :disabled="disabled"
            :placeholder="placeholder"
        />
    </n-form-item>
</template>

<script setup>
import { phone } from "@/helpers";

const props = defineProps({
    phone: {
        type: Object,
        default: () => ({ country: "ID", number: null }),
    },
    label: {
        type: String,
        default: "Phone number",
    },
    placeholder: {
        type: String,
        default: "Enter contact phone number...",
    },
    path: {
        type: String,
        default: "phone.number",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:phone"]);

const value = computed({
    get() {
        return props.phone;
    },
    set(value) {
        emit("update:phone", value);
    },
});

const rule = {
    number: {
        trigger: ["input", "blur"],
        required: true,
        validator: (rule, val) => {
            if (!val) {
                return new Error("Please input phone number");
            } else if (!phone(val, value.value.country)?.isValid() ?? false) {
                return new Error("Please input valid phone number");
            }
            return true;
        },
    },
};

defineExpose({
    rule,
});
</script>
