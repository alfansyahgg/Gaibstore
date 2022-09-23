<template>
    <div class="wrapper">
        <dashboard-content-layout>
            <template #headerName> Create User </template>
            <template #headerButton>
                <n-button
                    type="primary"
                    size="medium"
                    @click.prevent="formSubmit"
                >
                    <template #icon>
                        <n-icon>
                            <save-outline />
                        </n-icon>
                    </template>
                    Save
                </n-button>
            </template>
            <template #content>
                <div class="content-wrap flex justify-center flex-1">
                    <div class="photoForm flex flex-col w-1/6">
                        <h3 class="font-bold pb-4">User Avatar</h3>
                        <n-upload
                            :default-upload="false"
                            ref="uploadRef"
                            @change="handleChange"
                            accept=".png, .jpeg, .jpg"
                            class="!pr-4"
                            :max="1"
                        >
                            <n-button size="large">Upload Avatar</n-button>
                        </n-upload>
                        <n-spin :show="previewLoading" class="!pr-6">
                            <n-avatar
                                object-fit="cover"
                                :src="previewImage || imageAvatar"
                                :fallback-src="imageAvatar"
                                class="!cursor-pointer !w-full !h-24"
                            />
                        </n-spin>
                    </div>
                    <div class="userForm w-5/6">
                        <h3 class="font-bold pb-4">User Form</h3>
                        <user-form ref="formRef" v-model="formModel" />
                    </div>
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
import { SaveOutline } from "@vicons/ionicons5";
import { useForm } from "@inertiajs/inertia-vue3";
import { request } from "@/helpers";
//icons
import { ArchiveOutline as ArchiveIcon } from "@vicons/ionicons5";
import { useMessage } from "naive-ui";
import imageAvatar from "@images/avatar.png";

// utils
const route = inject("$route");
const message = useMessage();

// ref
const formRef = ref(null);
const photoRef = ref(null);
const previewLoading = ref(false);
const previewImage = ref(null);

// form Model
const formModel = useForm({
    photo: null,
    name: null,
    email: null,
    role: null,
    active: null,
    password: null,
});

// select image
function handleChange(data) {
    photoRef.value = data.file.file;
    formModel.photo = data.file.file;
}

watch(photoRef, (newValue) => {
    if (newValue) {
        previewLoading.value = true;
        var reader = new FileReader();
        reader.onload = function (e) {
            previewLoading.value = false;
            previewImage.value = e.target.result;
        };

        reader.readAsDataURL(newValue);
    }
});

// form submit
function formSubmit() {
    formRef.value?.validate((errors) => {
        if (!errors) {
            let statusMessage = message.create(`Saving User...`, {
                type: "loading",
                duration: 0,
            });

            formModel.post(route("user.store"), {
                onFinish: () => {
                    statusMessage.destroy();
                },
                onSuccess: (page) => {
                    message.info(page.props.flash.message);
                    formModel.reset();
                },
                onError: (errors) => {
                    for (const e in errors) {
                        message.error(errors[e], {
                            duration: 2500,
                        });
                    }
                },
            });
        } else {
            errors.forEach((item) => {
                message.error(item[0].message);
            });
        }
    });
}
</script>