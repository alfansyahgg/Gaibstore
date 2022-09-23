<template>
    <n-form-item
        ref="formVariantRef"
        label="Variant"
        :path="path"
        :required="rule.required"
    >
        <n-space vertical>
            <n-input-group v-for="(item, index) in value" :key="index">
                <n-input
                    v-model:value="value[index].color"
                    placeholder="Color"
                    :style="{ width: '28%' }"
                />
                <n-input
                    v-model:value="value[index].size"
                    placeholder="Size"
                    :style="{ width: '28%' }"
                />
                <n-input-number
                    v-model:value="value[index].stock"
                    placeholder="Stock"
                    :style="{ width: '28%' }"
                />
                <div class="pl-4 flex gap-2">
                    <n-button
                        type="error"
                        @click="removeVariant(index)"
                        :disabled="value.length == 1"
                    >
                        -
                    </n-button>
                    <n-button type="success" @click="addVariant(index)">
                        +
                    </n-button>
                </div>
            </n-input-group>
        </n-space>
    </n-form-item>
</template>
<script setup>
//ref
const props = defineProps({
    variant: {
        type: Array,
        default: () => [],
    },
    path: {
        type: String,
        default: "variant",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:variant"]);
const value = computed({
    get() {
        return props.variant;
    },
    set(value) {
        emit("update:variant", value);
    },
});

console.log(value.value);

// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "Product Variant Cannot Be Empty!",
};

// variant func
function addVariant(index) {
    const dup = {
        ...value.value[index],
    };

    value.value.push(dup);
}
function removeVariant(index) {
    value.value.pop(index);
}

defineExpose({
    rule,
});
</script>
