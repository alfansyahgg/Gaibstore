<template>
    <div class="wrapper">
        <dashboard-content-layout>
            <template #headerName> Manage Products </template>
            <template #headerButton>
                <modal-delete
                    :rows="checkedRow"
                    :api="$route('product.mass-destroy')"
                    group="products"
                ></modal-delete>
                <base-link
                    :href="$route('product.create')"
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
                        Create Product
                    </n-button>
                </base-link>
            </template>
            <template #content>
                <div class="content-wrapper">
                    <dashboard-table
                        ref="tableRef"
                        :columns="columns"
                        :pagination="true"
                        :bordered="false"
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
const tableRef = ref(null);
const checkedRow = shallowRef([]);

// Data
const props = inject("$page").value.props;
const data = computed(() => props.data);
const role = props.auth.user.role;
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
    {
        label: "Detail",
        key: "detail",
    },
];

// handle select
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
        route("product.edit", { product: selectedRow.value.id }),
        "get"
    );
}

function deleteRow() {
    request(
        `Deleting ${selectedRow.value.name}`,
        route("product.destroy", { product: selectedRow.value.id }),
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
        title: "",
        key: "avatar",
        align: "center",
        width: "80",
        render(row) {
            return h(NAvatar, {
                size: "800",
                src: row.photo ? row.photo : imgUrl + "avatar.png",
                fallbackSrc: productAvatar,
            });
        },
    },
    {
        title: "Name",
        key: "name",
    },
    {
        title: "Brand",
        key: "brand",
    },
    {
        title: "Price",
        key: "price",
    },
    {
        title: "Variants",
        key: "variants",
        render(row) {
            return `${row.variants} Variants`;
        },
    },
    {
        title: "Category",
        key: "category",
        render(row) {
            if (row.categories.length > 0) {
                return row.categories.map((item) => {
                    return h(
                        NTag,
                        {
                            style: {
                                marginRight: "6px",
                                marginBottom: "3px",
                            },
                            type: "info",
                            bordered: false,
                        },
                        {
                            default: () => item.name,
                        }
                    );
                });
            }
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
]);
</script>
