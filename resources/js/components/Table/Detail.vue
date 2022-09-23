<template>
    <n-data-table
        :columns="tableColumns"
        :data="tableData"
        :pagination="false"
        :bordered="false"
        :row-props="tableRowProps"
        :row-class-name="tableRowClassName"
        :theme-overrides="tableTheme"
        :max-height="tableHeight"
        virtual-scroll
    />
</template>
<script setup>
const props = defineProps({
    columns: {
        type: Array,
        default: () => [],
    },
    data: {
        type: Array,
        default: () => [],
    },
    rowProps: {
        type: Function,
        default: () => {},
    },
    rowClassName: {
        type: Function,
        default: () => {},
    },
    theme: {
        type: Object,
        default: () => {},
    },
    height: {
        type: Number,
        default: 250,
    },
});

const tableColumns = computed(() => props.columns);
const tableData = computed(() => props.data);
const tableRowProps = computed(() => props.rowProps);
const tableRowClassName = computed(() => props.rowClassName);
const tableTheme = computed(() => props.theme);
const tableHeight = computed(() => props.height);
</script>
