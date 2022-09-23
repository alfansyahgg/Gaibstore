<template>
    <n-data-table
        remote
        striped
        :columns="tableColumns"
        :data="tableData"
        :pagination="tablePagination"
        :row-key="tableRowKey"
        :bottom-bordered="false"
        @update:checked-row-keys="handleCheck"
        @update:page="onUpdatePage"
    />
</template>
<script setup>
import { request } from "@/helpers";
import { Inertia } from "@inertiajs/inertia";

// props
const props = defineProps({
    columns: {
        type: Array,
        default: () => [],
    },
    searchUrl: {
        type: String,
        default: "",
    },
    data: {
        type: Array,
        default: () => [],
    },
    checked: {
        type: Array,
        default: () => [],
    },
    rowKey: {
        type: Array,
        default: () => [],
    },
    bordered: {
        type: Boolean,
        default: false,
    },
    pagination: {
        type: Object,
        default: () => ({
            page: 1,
            pageCount: 1,
            pageSize: 10,
        }),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

// ref
const tableColumns = computed(() => props.columns);

//Row Table
const tableRowKey = (row) => row.id;

// emit
const emit = defineEmits(["update:checked", "update:filters"]);

// data
const tableData = computed({
    get() {
        return props.data;
    },
    set(newValue) {
        emit("update:data", newValue);
    },
});

//filters
const tableFilters = computed({
    get() {
        return props.filters;
    },
    set(newValue) {
        emit("update:filters", _.pickBy(newValue));
    },
});

// checked
const tableChecked = computed({
    get() {
        return props.checked;
    },
    set(newValue) {
        emit("update:checked", newValue);
    },
});

//pagination
const tablePagination = computed(() => {
    return props.pagination;
});

const onUpdatePage = (currentPage) => {
    tableFilters.value.page = currentPage;
};

// handle checked / selected row
function handleCheck(rowKeys) {
    tableChecked.value = rowKeys;
}

watch(
    tableFilters.value,
    _.throttle(() => {
        Inertia.visit(props.searchUrl, {
            data: _.pickBy(tableFilters.value),
            preserveState: true,
        });
    }, 200)
);
</script>
