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
                    Update
                </n-button>
            </template>
            <template #content>
                <div class="content-wrap flex flex-1">
                    <div class="photoForm w-2/6">
                        <h3 class="font-bold pb-4">Product Photos</h3>
                        <n-upload
                            ref="uploadRef"
                            :disabled="fileLength > 5"
                            :default-file-list="preview"
                            list-type="image-card"
                            @preview="handlePreview"
                            :default-upload="false"
                            @change="handleChange"
                            accept=".png, .jpeg, .jpg"
                        />
                        <n-modal
                            v-model:show="showModalRef"
                            preset="card"
                            style="width: 600px"
                            :title="product.name"
                        >
                            <img
                                :src="previewImageUrlRef"
                                style="width: 100%"
                            />
                        </n-modal>
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
import { request } from "@/helpers";
//icons
import { ArchiveOutline as ArchiveIcon } from "@vicons/ionicons5";
import { useMessage } from "naive-ui";

// utils
const route = inject("$route");
const message = useMessage();
const product = inject("$page").value.props.product;
const variants = inject("$page").value.props.variants;
const preview = inject("$page").value.props.preview;

// ref
const formRef = ref(null);
const uploadRef = ref(null);
const fileLength = ref(0);
const previewImageUrlRef = ref("");
const showModalRef = ref(false);

// category
const get_category = inject("$page").value.props.category;
const product_category = inject("$page").value.props.product_category;
const category = get_category.map((element) => ({
    label: element.name,
    value: element.id,
}));
const category_id = product_category.map((element) => element.id);

// form Model
const formModel = useForm({
    _method: "put",
    photos: [],
    name: product.name,
    brand: product.brand,
    desc: product.desc,
    price: product.price,
    category: category_id,
    variant: variants,
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

            formModel.post(
                route("product.update", {
                    product: product.id,
                }),
                {
                    onFinish: () => {
                        statusMessage.destroy();
                    },
                    onSuccess: (page) => {
                        message.success(page.props.flash.message);
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
        } else {
            errors.forEach((item) => {
                message.error(item[0].message);
            });
        }
    });
}

// handle preview
function handlePreview(file) {
    const { url } = file;
    previewImageUrlRef.value = url;
    showModalRef.value = true;
}
</script>
