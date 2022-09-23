<template>
    <n-form ref="formRef" :model="formModel" :rules="formRules">
        <checkout-form-first-name
            ref="formFnameRef"
            v-model:fname="formModel.fname"
            path="fname"
        ></checkout-form-first-name>
        <checkout-form-last-name
            ref="formLnameRef"
            v-model:lname="formModel.lname"
            path="lname"
        ></checkout-form-last-name>
        <checkout-form-phone
            ref="formPhoneRef"
            v-model:phone="formModel.phone"
            path="phone.number"
        ></checkout-form-phone>
        <checkout-form-city
            ref="formCityRef"
            v-model:city="formModel.city"
            path="city.id"
        ></checkout-form-city>
        <checkout-form-address
            ref="formAddressRef"
            v-model:address="formModel.address"
            path="address"
        ></checkout-form-address>
        <checkout-form-zip
            ref="formZipRef"
            v-model:zip="formModel.zip_code"
            path="zip"
        ></checkout-form-zip>
        <checkout-form-courier
            ref="formCourierRef"
            v-model:courier="formModel.courier"
            path="courier.code"
        ></checkout-form-courier>
        <checkout-form-service
            ref="formServiceRef"
            v-model:courier="formModel.courier"
            path="courier.service"
            :cost="cost"
        ></checkout-form-service>
    </n-form>
</template>
<script setup>
// ref
const formRef = ref(null);
const formFnameRef = ref(null);
const formLnameRef = ref(null);
const formPhoneRef = ref(null);
const formCityRef = ref(null);
const formAddressRef = ref(null);
const formZipRef = ref(null);
const formCourierRef = ref(null);
const formServiceRef = ref(null);

// props
const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({}),
    },
    photo: {
        type: Boolean,
        default: true,
    },
    cost: {
        type: Array,
        default: () => [],
    },
});
const emit = defineEmits(["update:modelValue"]);
const formModel = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});
const cost = computed(() => props.cost);

const includePhoto = computed(() => props.photo);

// rules
const formRules = computed(() => {
    return {
        fname: formFnameRef.value?.rule,
        lname: formLnameRef.value?.rule,
        phone: formPhoneRef.value?.rule,
        address: formAddressRef.value?.rule,
        city: formCityRef.value?.rule,
        zip: formZipRef.value?.rule,
        courier: {
            code: formCourierRef.value?.rule,
            service: formServiceRef.value?.rule,
        },
    };
});
// expose
function validate(callback) {
    formRef.value?.validate(callback);
}

defineExpose({
    validate,
});
</script>
