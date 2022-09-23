<template>
    <n-form-item
        ref="formPriceRef"
        :path="path"
        :required="rule.required"
        label="Price"
    >
        <n-input
            v-model:value="value"
            :allow-input="onlyAllowNumber"
            placeholder="Enter product price..."
            @keydown.enter.prevent
        >
            <template #prefix>
                <component :is="prefix" />
            </template>
        </n-input>
    </n-form-item>
</template>
<script setup>
import { NTag, NText } from "naive-ui";
import { thousand } from "@/helpers";

// Form Setup
const formPriceRef = ref(null);
const props = defineProps({
    price: {
        type: Number,
        default: null,
    },
    path: {
        type: String,
        default: "price",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:price"]);
const value = computed({
    get() {
        return props.price;
    },
    set(value) {
        emit("update:price", value);
    },
});

// Setting
function onlyAllowNumber(value) {
    return !value || /^\d+$/.test(value);
}

function prefix() {
    return h(
        "div",
        {
            class: "pr-2",
        },
        {
            default: () => "Rp. ",
        }
    );
}

// rules
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "Product Price Cannot Be Empty!",
};

defineExpose({
    rule,
});
</script>