<template>
    <n-table striped :bordered="false">
        <tbody>
            <tr v-for="(row, index) in shipRows" :key="index">
                <td>{{ row.label }}</td>
                <td>:</td>
                <td>
                    {{ row.value }}
                </td>
            </tr>
        </tbody>
    </n-table>
</template>
<script setup>
const data = computed(() => inject("$page").value.props.data);
const order = computed(() => data.value.order);
const shipping = computed(() => order.value.shipping);
const shipRows = ref([
    {
        label: "Courier",
        value: shipping.value.shipping_code.toUpperCase(),
    },
    {
        label: "Destination",
        value: shipping.value.destination.city_name,
    },
    {
        label: "Estimated Days",
        value: shipping.value.shipping_etd,
    },
    {
        label: "Service",
        value: shipping.value.shipping_name,
    },
    {
        label: "Weight",
        value: shipping.value.shipping_weight + " Gr",
    },
    {
        label: "Cost",
        value: "Rp. " + shipping.value.shipping_cost.toLocaleString("id-ID"),
    },
    {
        label: "Recipient Name",
        value: shipping.value.first_name + " " + shipping.value.last_name,
    },
    {
        label: "Recipient Address",
        value: shipping.value.address,
    },
    {
        label: "Recipient City",
        value: shipping.value.city,
    },
]);
</script>
