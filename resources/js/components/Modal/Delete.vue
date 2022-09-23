<template>
    <n-button
        type="error"
        size="medium"
        v-if="rows.length > 0"
        @click="openModal"
    >
        <template #icon>
            <n-icon class="!text-white">
                <trash />
            </n-icon>
        </template>
        Delete All
    </n-button>

    <n-modal
        v-model:show="deleteModal"
        preset="dialog"
        title="Dialog"
        :content="
            'Are you sure want to delete ' + rows.length + ' ' + group + ' ?'
        "
        positive-text="Submit"
        negative-text="Cancel"
        @positive-click="submit"
        @negative-click="deleteModal = false"
    />
</template>
<script setup>
import { useMessage } from "naive-ui";
import { Trash } from "@vicons/ionicons5";
import request from "@/helpers/request";

const props = defineProps({
    rows: {
        type: Array,
        default: () => [],
    },
    api: {
        type: String,
        default: "",
    },
    group: {
        type: String,
        default: "",
    },
});
//ref
const deleteModal = ref(false);

// utils
window.$message = useMessage();

// functions
function openModal() {
    deleteModal.value = true;
}

function submit() {
    request(
        "Deleting...",
        props.api,
        "delete",
        {
            [props.group]: props.rows,
        },
        {
            onSuccess: (page) => {
                window.$message.info(page.props.flash.message);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            },
        }
    );
}
</script>
