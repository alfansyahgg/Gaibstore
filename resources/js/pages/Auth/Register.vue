<template>
    <div class="wrapper">
        <auth-layout>
            <div class="flex flex-col">
                <h3
                    class="text-center text-primary-500 font-semibold text-3xl pb-4"
                >
                    Welcome to Gaibstore!
                </h3>
                <auth-regist-form
                    ref="formRef"
                    v-model="formModel"
                ></auth-regist-form>
                <div class="pb-4">
                    <n-button
                        type="primary"
                        class="!w-full"
                        @click="formSubmit"
                    >
                        Sign Up
                    </n-button>
                </div>
            </div>
        </auth-layout>
    </div>
</template>
<script>
import RootLayout from "@/layouts/RootLayout.vue";
import PageLayout from "@/layouts/PageLayout.vue";
export default {
    layout: [RootLayout, PageLayout],
};
</script>
<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { useMessage } from "naive-ui";
// utils
const page = inject("$page").value.props;
const message = useMessage();

// ref
const formRef = ref(null);
const formLoading = ref(false);
console.log(page);
// form Model
const formModel = useForm({
    email: null,
    password: null,
    fname: null,
    lname: null,
    phone: {
        number: "",
        country: "ID",
    },
    address: null,
    city: {
        id: null,
        name: null,
    },
    zip_code: null,
});

// form submit
function formSubmit() {
    formRef.value?.validate((errors) => {
        if (!errors) {
            formLoading.value = true;

            let statusMessage = message.create(`Please wait a moment...`, {
                type: "loading",
                duration: 0,
            });

            formModel.post(route("auth.regist"), {
                onFinish: () => {
                    formLoading.value = false;
                    statusMessage.destroy();
                },
                onSuccess: () => {
                    message.success("Successfully registering your account");
                },
                onError: (errors) => {
                    for (const e in errors) {
                        message.error(errors[e], {
                            duration: 2500,
                        });
                    }
                },
            });
        }
    });
}
</script>
