<template>
    <div class="wrapper">
        <dashboard-content-layout>
            <template #headerName> Create Product </template>
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
                <div class="content-wrap flex flex-1">
                    <div class="photoForm w-2/6">
                        <h3 class="font-bold pb-4">Product Photos</h3>
                        <n-upload
                            ref="uploadRef"
                            :disabled="fileLength > 5"
                            multiple
                            directory-dnd
                            :max="5"
                            :default-upload="false"
                            @change="handleChange"
                            accept=".png, .jpeg, .jpg"
                            class="!pr-4"
                        >
                            <n-upload-dragger>
                                <div style="margin-bottom: 12px">
                                    <n-icon size="48" :depth="3">
                                        <archive-icon />
                                    </n-icon>
                                </div>
                                <n-text style="font-size: 16px">
                                    Click or drag a file to this area to upload
                                </n-text>
                                <n-p depth="3" style="margin: 8px 0 0 0">
                                    Strictly prohibit from uploading sensitive
                                    information. For example, your bank card PIN
                                    or your credit card expiry date.
                                </n-p>
                            </n-upload-dragger>
                        </n-upload>
                    </div>
                    <div class="productForm w-4/6">
                        <h3 class="font-bold pb-4">Product Form</h3>
                        <product-form
                            ref="formRef"
                            v-model="formModel"
                            :category="category"
                        />
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
//icons
import { ArchiveOutline as ArchiveIcon } from "@vicons/ionicons5";
import { useMessage } from "naive-ui";

// utils
const route = inject("$route");
const message = useMessage();

// ref
const formRef = ref(null);
const uploadRef = ref(null);
const fileLength = ref(0);

// category
const get_category = inject("$page").value.props.category;
const category = get_category.map((element) => ({
    label: element.name,
    value: element.id,
}));

// form Model
const formModel = useForm({
    photos: [],
    name: null,
    brand: null,
    desc: null,
    price: null,
    category: [],
    variant: [
        {
            color: "",
            size: "",
            stock: 0,
        },
    ],
});

// select image
function handleChange(data) {
    fileLength.value = data.fileList.length;
    formModel.photos.push(data.file.file);
}

// form submit
function formSubmit() {
    formRef.value?.validate((errors) => {
        if (!errors) {
            let statusMessage = message.create(`Saving Product...`, {
                type: "loading",
                duration: 0,
            });

            formModel.post(route("product.store"), {
                onFinish: () => {
                    statusMessage.destroy();
                },
                onSuccess: (page) => {
                    message.success(page.props.flash.message);
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
