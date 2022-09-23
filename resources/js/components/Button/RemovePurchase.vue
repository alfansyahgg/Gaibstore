<template>
    <n-button type="error" @click="remove(id)">
        <template #icon>
            <n-icon>
                <trash-bin-outline />
            </n-icon>
        </template>
        <b>Remove</b>
    </n-button>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import { TrashBinOutline } from "@vicons/ionicons5";
import { useMessage } from "naive-ui";

// props
const props = defineProps({
    id: {
        type: Object,
        default: () => ({}),
    },
});

// utils
const message = useMessage();

function remove(id) {
    Inertia.delete(
        route("checkout.remove-order", {
            order: id,
        }),
        {
            onSuccess: (page) => {
                message.success(page.props.flash.success);
            },
        }
    );
}
</script>
