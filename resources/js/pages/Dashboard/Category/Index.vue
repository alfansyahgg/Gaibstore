<template>
    <div class="wrapper">
        <dashboard-content-layout>
            <template #headerName> Manage Categories </template>
            <template #headerButton>
                <modal-delete
                    :rows="checkedRow"
                    :api="$route('category.mass-destroy')"
                    group="categories"
                ></modal-delete>
                <base-link
                    :href="$route('category.create')"
                    as="button"
                    :disabled="!props.can.create"
                >
                    <n-button
                        type="primary"
                        size="medium"
                        :disabled="!props.can.create"
                    >
                        <template #icon>
                            <n-icon>
                                <add-outline />
                            </n-icon>
                        </template>
                        Create Category
                    </n-button>
                </base-link>
            </template>
            <template #content>
                <div class="content-wrapper">
                    <dashboard-table
                        ref="tableRef"
                        :columns="columns"
                        v-model:data="data"
                        :pagination="true"
                        :bordered="false"
                        v-model:checked="checkedRow"
                    >
                    </dashboard-table>
                    <n-dropdown
                        placement="bottom-start"
                        trigger="manual"
                        :x="xRef"
                        :y="yRef"
                        :options="options"
                        :show="showDropdownRef"
                        @select="handleSelect"
                    />
                </div>
            </template>
        </dashboard-content-layout>
    </div>
</template>
<script>
import RootLayout from "@/layouts/RootLayout.vue";
import DashboardLayout from "@/layouts/DashboardLayout.vue";
export default {
    layout: [RootLayout, DashboardLayout],
};
</script>

<script setup>
import { AddOutline, EllipsisVertical } from "@vicons/ionicons5";
import { NAvatar, NButton, NIcon, NTag, useMessage } from "naive-ui";
import { request } from "@/helpers";
import productAvatar from "@images/box.png";

// utils
window.$message = useMessage();
const route = inject("$route");
const imgUrl = inject("$images");

// ref
const pagination = ref(false);
const showDropdownRef = ref(false);
const xRef = ref(0);
const yRef = ref(0);
const selectedRow = ref(null);
const checkedRow = shallowRef([]);

// Data
const props = inject("$page").value.props;
const data = computed(() => props.data);
// Dropdown Options
const options = [
    {
        label: "Edit",
        key: "edit",
    },
    {
        label: "Delete",
        key: "delete",
    },
];

// handle checked / selected row
function handleCheck(rowKeys) {
    checkedRow.value = rowKeys;
}

// handle select dropdown
function handleSelect(key) {
    showDropdownRef.value = false;
    switch (key) {
        case "delete":
            deleteRow();
            break;
        case "edit":
            editRow();
            break;

        default:
            break;
    }
}
function editRow() {
    request(
        `Opening ${selectedRow.value.name}...`,
        route("category.edit", { category: selectedRow.value.id }),
        "get"
    );
}

function deleteRow() {
    request(
        `Deleting ${selectedRow.value.name}`,
        route("category.destroy", { category: selectedRow.value.id }),
        "delete",
        null,
        {
            onSuccess: (page) => {
                window.$message.success(page.props.flash.message);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            },
        }
    );
}

//Columns
const createColumns = () => {
    return [
        {
            type: "selection",
        },
        {
            title: "No",
            key: "no",
            width: "50",
            render(row, index) {
                return index + 1;
            },
        },
        {
            title: "Name",
            key: "name",
        },
        {
            title: "Description",
            key: "desc",
        },
        {
            title: "Total Products",
            key: "total_products",
        },
        {
            title: "Action",
            key: "actions",
            align: "center",
            render: (row) => {
                return h(
                    NIcon,
                    {
                        size: 20,
                        style: {
                            cursor: "pointer",
                        },
                        onClick: (e) => {
                            e.preventDefault();
                            if (!props.can.create) {
                                return false;
                            }
                            showDropdownRef.value = false;
                            nextTick().then(() => {
                                selectedRow.value = row;
                                showDropdownRef.value = true;
                                xRef.value = e.clientX;
                                yRef.value = e.clientY;
                            });
                        },
                    },
                    {
                        default: () =>
                            h(EllipsisVertical, null, {
                                default: () => null,
                            }),
                    }
                );
            },
        },
    ];
};

//Row Table
const rowKey = (row) => row.id;
const columns = createColumns();
</script>
