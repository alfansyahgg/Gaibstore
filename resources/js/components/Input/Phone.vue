<template>
    <n-input-group>
        <n-select
            v-model:show="countryShow"
            v-model:value="countryValue"
            :options="countryOptions"
            :render-label="countryRenderLabel"
            :render-tag="countryRenderTag"
            :style="{ width: '25%' }"
            :disabled="disabled"
            filterable
            :filter="countryFilter"
            placement="top"
            :consistent-menu-width="false"
        >
            <template v-if="countryShow" #arrow>
                <search />
            </template>
        </n-select>
        <n-input
            v-model:value="number"
            :placeholder="placeholder"
            :allow-input="onlyAllowNumber"
            maxlength="20"
            show-count
            :disabled="disabled"
            :style="{ width: 'calc(100% - 100px)' }"
        />
    </n-input-group>
</template>

<script setup>
import { Search } from "@vicons/ionicons5";
import { phoneCountry } from "@/enums";

// only allow number
const onlyAllowNumber = (value) => !value || /^\d+$/.test(value);

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({ number: null, country: "ID" }),
    },
    placeholder: {
        type: String,
        default: "123456789",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:modelValue"]);

const value = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});
const countryShow = ref(false);
const countryValue = computed({
    get() {
        return value.value.country;
    },
    set(newValue) {
        value.value.country = newValue;
    },
});
const countryOptions = phoneCountry.map((country) => {
    return {
        label: `${country.value} ${country.code}`,
        value: country.value,
        name: country.text,
    };
});
const countryRenderLabel = (option) => {
    return h("div", { class: "flex flex-col truncate py-1" }, [
        h("div", { class: "truncate" }, option.label),
        h(
            "div",
            { class: "text-gray-400 text-sm font-light truncate" },
            option.name
        ),
    ]);
};
const countryRenderTag = ({ option }) => {
    return option.label;
};
const countryFilter = (pattern, option) => {
    pattern = String(pattern).toLocaleLowerCase();
    return (
        option.label.toLowerCase().includes(pattern) ||
        option.name.toLowerCase().includes(pattern)
    );
};
const number = computed({
    get() {
        return value.value.number;
    },
    set(newValue) {
        value.value.number = newValue;
    },
});
</script>
