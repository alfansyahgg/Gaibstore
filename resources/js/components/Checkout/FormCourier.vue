<template>
    <n-form-item
        ref="formCourierRef"
        label="Courier"
        :path="path"
        :required="rule.required"
    >
        <n-select
            v-model:value="courierCode"
            filterable
            tag
            :options="courierOptions"
            :consistent-menu-width="false"
        />
    </n-form-item>
</template>
<script setup>
import { Inertia } from "@inertiajs/inertia";

// utils
const { _, axios } = window;

// props
const props = defineProps({
    courier: {
        type: Object,
        default: () => ({
            code: null,
            name: null,
            cost: null,
            service: null,
            etd: null,
        }),
    },
    path: {
        type: String,
        default: "courier.code",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:courier"]);

const courier = computed({
    get() {
        return props.courier;
    },
    set(value) {
        emit("update:courier", value);
    },
});

const courierCode = computed({
    get() {
        return courier.value.code;
    },
    set(value) {
        courier.value.code = value;
    },
});
// ref
const courierOptions = ref([
    {
        label: "JNE",
        value: "jne",
    },
    {
        label: "Pos",
        value: "pos",
    },
    {
        label: "Tiki",
        value: "tiki",
    },
]);
// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "Courier Cannot Be Empty!",
};

defineExpose({
    rule,
});
</script>
