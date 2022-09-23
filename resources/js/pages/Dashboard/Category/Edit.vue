<template>
    <div class="wrapper">
        <dashboard-content-layout>
            <template #headerName> Edit {{ category.name }} </template>
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
                <base-link :href="$route('category.index')">
                    <n-button type="default" size="medium" tertiary>
                        <template #icon>
                            <n-icon>
                                <arrow-undo />
                            </n-icon>
                        </template>
                        Cancel
                    </n-button>
                </base-link
                >
            </template>
            <template #content>
                <div class="content-wrap flex justify-center flex-1">
                    <div class="CategoryForm w-4/6">
                        <h3 class="font-bold pb-4">Category Form</h3>
                        <category-form ref="formRef" v-model="formModel" />
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
import { useForm } from "@inertiajs/inertia-vue3";
import { request } from "@/helpers";
//icons
import {
    ArchiveOutline as ArchiveIcon,
    SaveOutline,
    ArrowUndo,
} from "@vicons/ionicons5";
import { useMessage } from "naive-ui";

// utils
const route = inject("$route");
const message = useMessage();
const category = inject("$page").value.props.category;
const photos = inject("$page").value.props.photos;

// ref
const formRef = ref(null);

// form Model
const formModel = useForm({
    _method: "put",
    ...category,
});

// form submit
function formSubmit() {
    formRef.value?.validate((errors) => {
        if (!errors) {
            let statusMessage = message.create(`Saving Category...`, {
                type: "loading",
                duration: 0,
            });

            formModel.post(
                route("category.update", {
                    category: category.id,
                }),
                {
                    onFinish: () => {
                        statusMessage.destroy();
                    },
                    onSuccess: (page) => {
                        message.info(page.props.flash.message);
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
</script>