<template>
    <div class="wrapper">
        <dashboard-content-layout>
            <template #headerName> Manage Users </template>
            <template #headerButton>
                <modal-delete
                    :rows="checkedRow"
                    :api="$route('user.mass-destroy')"
                    group="users"
                ></modal-delete>
                <input-search
                    ref="searchRef"
                    v-model:search="tableFilters.search"
                ></input-search>
                <base-link
                    :href="$route('user.create')"
                    as="button"
                    v-show="props.can.create"
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
                        Create User
                    </n-button>
                </base-link>
            </template>
            <template #content>
                <div class="content-wrapper">
                    <dashboard-table
                        ref="tableRef"
                        :searchUrl="$route('user.index')"
                        :columns="columns"
                        :pagination="tablePagination"
                        :bordered="false"
                        v-model:filters="tableFilters"
                        v-model:data="data"
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
                        @clickoutside="showDropdownRef = false"
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
const { _ } = window;

// ref
const pagination = ref(false);
const showDropdownRef = ref(false);
const xRef = ref(0);
const yRef = ref(0);
const selectedRow = ref(null);
const checkedRow = shallowRef([]);

// Data
const props = computed(() => inject("$page").value.props);
const table = computed(() => props.value.data);
const data = computed(() => table.value.data);
const filters = computed(() => props.value.filters);

// filters;
const tableFilters = reactive({
    ...filters.value,
});

// pagination
const tablePagination = computed(() => {
    return {
        itemCount: table.value.meta.total,
        page: table.value.meta.current_page,
        pageSize: table.value.meta.per_page,
        prefix({ itemCount }) {
            return `${itemCount} total users.`;
        },
    };
});

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
        `Opening...`,
        route("user.edit", { user: selectedRow.value.id }),
        "get"
    );
}

function deleteRow() {
    request(
        `Deleting...`,
        route("user.destroy", { user: selectedRow.value.id }),
        "delete"
    );
}

//Columns
const columns = ref([
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
        title: "Email",
        key: "email",
    },
    {
        title: "Role",
        key: "role",
    },
    {
        title: "Status",
        key: "status",
        align: "center",
        width: 100,
        render: (row) => {
            return h(
                NTag,
                {
                    bordered: false,
                    type: row.active === 1 ? "success" : "error",
                },
                {
                    default: () => {
                        if (row.active == 1) {
                            return "Active";
                        }
                        return "Inactive";
                    },
                }
            );
        },
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
                        if (!props.value.can.create) {
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
]);

//Row Table
const rowKey = (row) => row.id;
</script>
