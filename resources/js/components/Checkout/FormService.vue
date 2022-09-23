<template>
    <n-form-item
        ref="formServiceRef"
        label="Service"
        :path="path"
        :required="rule.required"
        v-if="dataCost != null"
    >
        <n-select
            v-model:value="courierService"
            filterable
            tag
            :options="options"
            :consistent-menu-width="false"
            @update:value="updateSelect"
        />
    </n-form-item>
</template>
<script setup>
import { Inertia } from "@inertiajs/inertia";
import { useMessage } from "naive-ui";

// utils
const { _, axios } = window;
const message = useMessage();

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
        default: "courier.service",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    cost: {
        type: Array,
        default: () => [],
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

const courierName = computed({
    get() {
        return courier.value.name;
    },
    set(value) {
        courier.value.name = value;
    },
});

const courierCost = computed({
    get() {
        return courier.value.cost;
    },
    set(value) {
        courier.value.cost = value;
    },
});

const courierService = computed({
    get() {
        return courier.value.service;
    },
    set(value) {
        courier.value.service = value;
    },
});

const courierEtd = computed({
    get() {
        return courier.value.etd;
    },
    set(value) {
        courier.value.etd = value;
    },
});

// render label

const dataCost = computed(() => props.cost);
const options = computed(() => {
    if (dataCost.value.rajaongkir.status.code == 400) {
        message.error(dataCost.value.rajaongkir.status.description);
        return false;
    } else {
        return _.map(dataCost.value.rajaongkir.results[0].costs, (item) => {
            return {
                label:
                    item.service +
                    " - Harga Rp." +
                    item.cost[0].value.toLocaleString("id-ID") +
                    " - Estimasti " +
                    item.cost[0].etd +
                    " Hari",
                value: item,
            };
        });
    }
});

// rule
const rule = {
    trigger: ["input", "blur"],
    required: true,
    message: "Service Cannot Be Empty!",
};

// ref
const updateSelect = (value, option) => {
    courierCost.value = value.cost[0].value;
    courierEtd.value = value.cost[0].etd;
    courierService.value = value.service;
    courierName.value = value.description;
};

defineExpose({
    rule,
});
</script>
