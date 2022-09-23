<template>
    <n-form-item
        ref="formCityRef"
        label="City"
        :path="path"
        :required="rule.required"
    >
        <n-select
            v-model:value="cityId"
            filterable
            tag
            :options="cityOptions"
            :consistent-menu-width="false"
            @update:value="updateSelect"
        />
    </n-form-item>
</template>
<script setup>
import { Inertia } from "@inertiajs/inertia";

// utils
const { _, axios } = window;
const cities = computed(() => inject("$page").value.props.data.city);
// props
const props = defineProps({
    city: {
        type: Object,
        default: () => {},
    },
    path: {
        type: String,
        default: "city",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:city"]);

const city = computed({
    get() {
        return props.city;
    },
    set(value) {
        emit("update:city", value);
    },
});
const cityId = computed({
    get() {
        return city.value.id;
    },
    set(value) {
        city.value.id = value;
    },
});
const cityName = computed({
    get() {
        return city.value.name;
    },
    set(value) {
        city.value.name = value;
    },
});
// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "City Name Cannot Be Empty!",
};

// ref

const cityOptions = _.map(cities.value, (item) => ({
    label: item.city_name,
    value: item.city_id,
}));

const updateSelect = (value, option) => {
    cityName.value = option.label;
};

defineExpose({
    rule,
});
</script>
