<template>
    <div class="wrapper p-8">
        <div class="head-title">
            <h3 class="!text-3xl text-primary-500 font-semibold pb-4">
                Dashboard
            </h3>
            <div class="stats">
                <n-grid :x-gap="12" :y-gap="8" :cols="5">
                    <n-grid-item v-for="item in itemsRef" :key="item.label">
                        <div
                            class="card-info p-8 bg-green-500 hover:bg-green-900 hover:cursor-pointer rounded-md shadow-md"
                        >
                            <div class="count">
                                <n-statistic
                                    tabular-nums
                                    class="!text-white !text-2xl !font-semibold"
                                    :theme-overrides="themeNumber"
                                >
                                    <n-number-animation
                                        ref="numberAnimationInstRef"
                                        :from="0"
                                        :to="item.total"
                                        active
                                    />
                                </n-statistic>
                            </div>
                            <div class="desc text-white text-lg">
                                Total {{ item.label }}
                            </div>
                        </div>
                    </n-grid-item>
                </n-grid>
            </div>
            <div class="table-order py-4">
                <div class="flex pb-4">
                    <div class="w-1/2">
                        <h3 class="!text-2xl text-primary-500 font-semibold">
                            Orders
                        </h3>
                    </div>
                    <div class="w-1/2 flex justify-end">
                        <input-search
                            ref="searchRef"
                            v-model:search="tableFilters.search"
                        ></input-search>
                    </div>
                </div>
                <dashboard-table
                    ref="tableRef"
                    :searchUrl="$route('dashboard')"
                    :columns="columns"
                    :pagination="tablePagination"
                    :bordered="false"
                    v-model:filters="tableFilters"
                    v-model:data="table.data"
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
        </div>
    </div>
</template>
<script>
import RootLayout from "@/layouts/RootLayout.vue";
import DashboardLayout from "@/layouts/DashboardLayout.vue";
import { NTag, NIcon } from "naive-ui";
import { EllipsisVertical } from "@vicons/ionicons5";
export default {
    layout: [RootLayout, DashboardLayout],
};
</script>
<script setup>
// utils
const data = computed(() => inject("$page").value.props.data);
const products = computed(() => data.value.products);
const categories = computed(() => data.value.categories);
const orders = computed(() => data.value.orders);
const users = computed(() => data.value.users);
const variants = computed(() => data.value.variants);

// ref
const itemsRef = ref([
    {
        label: "Products",
        total: products.value.total,
        color: "bg-green-500",
    },
    {
        label: "Users",
        total: users.value.total,
        color: "bg-green-600",
    },
    {
        label: "Categories",
        total: categories.value.total,
        color: "bg-green-700",
    },
    {
        label: "Orders",
        total: orders.value.total,
        color: "bg-green-800",
    },
    {
        label: "Variants",
        total: variants.value.total,
        color: "bg-green-500",
    },
]);
const ordertable = computed(() => data.value.orders);
const table = computed(() => ordertable.value.data);
const filters = computed(() => ordertable.value.filters);
const showDropdownRef = ref(false);
const xRef = ref(0);
const yRef = ref(0);
const selectedRow = ref(null);

// order columns
const columns = ref([
    {
        title: "No",
        key: "no",
        width: "50",
        render(row, index) {
            return index + 1;
        },
    },
    {
        title: "Order Key",
        key: "order_key",
    },
    {
        title: "Email",
        key: "user.email",
    },
    {
        title: "Amount",
        key: "total_price",
        render(row) {
            return "Rp. " + row.total_price.toLocaleString("id-ID");
        },
    },
    {
        title: "Payment Status",
        key: "payment_status",
        align: "center",
        width: 100,
        render: (row) => {
            return h(
                NTag,
                {
                    bordered: false,
                    type:
                        row.payment_status == 1
                            ? ""
                            : row.payment_status == 2
                            ? "success"
                            : row.payment_status == 3
                            ? "warning"
                            : "error",
                },
                {
                    default: () => {
                        switch (row.payment_status) {
                            case "1":
                                return "";
                            case "2":
                                return "success";
                            case "3":
                                return "warning";
                            case "4":
                                return "error";
                        }
                    },
                }
            );
        },
    },
    {
        title: "",
        key: "action",
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
            return `${itemCount} total orders.`;
        },
    };
});

// Dropdown Options
const options = [
    {
        label: "Detail",
        key: "detail",
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
        case "detail":
            detailRow();
            break;

        default:
            break;
    }
}
function detailRow() {
    request(
        `Opening...`,
        route("order.show", { order: selectedRow.value.id }),
        "get"
    );
}

function deleteRow() {
    request(
        `Deleting...`,
        route("order.destroy", { order: selectedRow.value.id }),
        "delete"
    );
}

const themeNumber = {
    valueTextColor: "rgb(255,255,255)",
};

onMounted(() => {});
</script>
<style scoped>
.n-statistic .n-statistic-value .n-statistic-value__content {
    font-size: 2rem !important;
    color: white !important;
}
</style>
