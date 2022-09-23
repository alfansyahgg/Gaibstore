<template>
    <profile-layout>
        <div class="wrapper">
            <div class="profile px-8 w-full">
                <account-form ref="formRef" v-model="formModel"></account-form>
                <div class="py-8">
                    <n-button
                        type="primary"
                        class="!w-full"
                        @click="formSubmit"
                        :disabled="formModel.processing"
                        :loading="formLoading"
                    >
                        <template #icon>
                            <n-icon>
                                <save />
                            </n-icon>
                        </template>
                        Update
                    </n-button>
                </div>
            </div>
        </div>
    </profile-layout>
</template>
<script>
import RootLayout from "@/layouts/RootLayout.vue";
import PageLayout from "@/layouts/PageLayout.vue";
export default {
    layout: [RootLayout, PageLayout],
};
</script>
<script setup>
import { useMessage } from "naive-ui";
import { useForm } from "@inertiajs/inertia-vue3";
import { Save } from "@vicons/ionicons5";

// utils
const route = inject("$route");
const message = useMessage();
const page = inject("$page").value.props;
const user = computed(() => page.auth.user);

// form Model
const formModel = useForm({
    _method: "put",
    email: null,
    password: {
        old: null,
        new: null,
        confirm: null,
    },
});

// ref
const formRef = ref(null);
const formLoading = ref(false);

// form submit
function formSubmit() {
    // console.log(formModel);
    formRef.value?.validate((errors) => {
        if (!errors) {
            formLoading.value = true;
            let statusMessage = message.create(
                `Updating Account Information...`,
                { type: "loading", duration: 0 }
            );
            formModel.post(
                route("profile.update-account", {
                    user: user.value.id,
                }),
                {
                    onFinish: () => {
                        formLoading.value = false;
                        statusMessage.destroy();
                    },
                    onSuccess: (newPage) => {
                        message.success(newPage.props.flash.success);
                        formModel.reset();
                    },
                    onError: (errors) => {
                        for (const e in errors) {
                            message.error(errors[e], {
                                duration: 2500,
                            });
                        }
                    },
                }
            );
        }
    });
}
</script>
