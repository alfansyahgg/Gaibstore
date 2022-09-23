<template>
    <n-modal
        v-model:show="props.logModal"
        preset="dialog"
        title="You about to leave the website"
        content="Are you sure?"
        positive-text="Yes"
        negative-text="Cancel"
        @positive-click="logout"
        @negative-click="cancel"
    />
</template>
<script setup>
import { request } from "@/helpers";
import { useMessage } from "naive-ui";
// props
const props = defineProps({
    logModal: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:logModal"]);
const value = computed({
    get() {
        return props.logModal;
    },
    set(newVal) {
        emit("update:logModal", newVal);
    },
});

// utils
const route = inject("$route");
window.$message = useMessage();

// yes
function logout() {
    request("Logging out...", route("auth.logout"), "post");
}

// no
function cancel() {
    value.value = false;
}
</script>
