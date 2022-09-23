<template>
    <n-table striped :bordered="false">
        <tbody>
            <tr v-for="(row, index) in transRows" :key="index">
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
const transaction = computed(() => data.value.transaction);
const transRows = ref([
    {
        label: "Payment Type",
        value: transaction.value.payment_type,
    },
    {
        label: "Bank",
        value: transaction.value.bank,
    },
    {
        label: "Virtual Account Number",
        value: transaction.value.va_number,
    },
    {
        label: "Transaction Status",
        value: transaction.value.transaction_status,
    },
    {
        label: "Transaction Time",
        value: transaction.value.transaction_time,
    },
]);

if (transaction.value.transaction_status == "settlement") {
    transRows.value.push({
        label: "Settlement Time",
        value: transaction.value.settlement_time,
    });
}
</script>
