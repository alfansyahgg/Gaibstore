<template>
    <profile-layout>
        <div class="wrapper">
            <div class="profile px-8 w-full">
                <profile-form ref="formRef" v-model="formModel"></profile-form>
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
                        Save
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
const profile_id = page.auth.user.profile_id;
const data = page.data.profile;
// form Model
const formModel = useForm({
    _method: "put",
    photo: null,
    photoPreview: data.photoPreview,
    fname: data.first_name,
    lname: data.last_name,
    phone: {
        number: data.phone_number,
        country: data.country,
    },
    address: data.address,
    city: {
        id: data.city_id,
        name: data.city,
    },
    zip_code: data.zip_code,
});

// ref
const formRef = ref(null);
const formLoading = ref(false);

// form submit
function formSubmit() {
    console.log(profile_id);
    formRef.value?.validate((errors) => {
        if (!errors) {
            formLoading.value = true;

            let statusMessage = message.create(
                `Saving Profile ${formModel.fname} ${formModel.lname} `,
                { type: "loading", duration: 0 }
            );

            formModel.post(
                route("profile.update", {
                    profile: profile_id,
                }),
                {
                    onFinish: () => {
                        formLoading.value = false;
                        statusMessage.destroy();
                    },
                    onSuccess: () => {
                        message.success("Successfully update profile!");
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

const fillShipping = () => {
    formModel.name = "aa";
};
</script>
