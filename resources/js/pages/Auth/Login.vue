<template>
    <auth-layout>
        <div class="!w-1/4 self-center">
            <h3
                class="text-center text-primary-500 font-semibold text-3xl pb-4"
            >
                Welcome to Gaibstore!
            </h3>
            <n-alert
                v-if="page.flash.success != null"
                title="Success"
                type="success"
                class="!mb-4"
            >
                {{ page.flash.success }}
            </n-alert>
            <auth-form ref="formRef" v-model:form="formModel" />
            <n-button
                class="!w-full"
                type="primary"
                size="medium"
                @click="formSubmit"
                >Sign In</n-button
            >
            <base-link :href="$route('auth.register')">
                <h3 class="text-center py-4 text-primary-300 underline">
                    Sign Up Now
                </h3>
            </base-link>
        </div>
    </auth-layout>
</template>
<script>
import RootLayout from "@/layouts/RootLayout.vue";
import PageLayout from "@/layouts/PageLayout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { useMessage } from "naive-ui";
export default {
    layout: [RootLayout, PageLayout],
};
</script>
<script setup>
const formRef = ref(null);
const formModel = useForm({
    email: null,
    password: null,
    remember: null,
});
const message = useMessage();
const route = inject("$route");
const page = inject("$page").value.props;
console.log(page);

function formSubmit() {
    formRef.value?.validate((errors) => {
        if (!errors) {
            let statusMessage = message.create(`Signing you in...`, {
                type: "loading",
                duration: 0,
            });

            formModel.post(route("auth.access"), {
                onFinish: () => {
                    statusMessage.destroy();
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
