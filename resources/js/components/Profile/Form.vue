<template>
    <n-form ref="formRef" :model="formModel" :rules="formRules">
        <profile-form-photo
            ref="formPhotoRef"
            v-if="includePhoto"
            v-model:photo="formModel.photo"
            :preview="formModel.photoPreview"
            path="photo"
        ></profile-form-photo>
        <profile-form-first-name
            ref="formFnameRef"
            v-model:fname="formModel.fname"
            path="fname"
        ></profile-form-first-name>
        <profile-form-last-name
            ref="formLnameRef"
            v-model:lname="formModel.lname"
            path="lname"
        ></profile-form-last-name>
        <profile-form-phone
            ref="formPhoneRef"
            v-model:phone="formModel.phone"
            path="phone.number"
        ></profile-form-phone>
        <profile-form-city
            ref="formCityRef"
            v-model:city="formModel.city"
            path="city.id"
        ></profile-form-city>
        <profile-form-address
            ref="formAddressRef"
            v-model:address="formModel.address"
            path="address"
        ></profile-form-address>
        <profile-form-zip
            ref="formZipRef"
            v-model:zip="formModel.zip_code"
            path="zip"
        ></profile-form-zip>
    </n-form>
</template>
<script setup>
// ref
const formRef = ref(null);
const formFnameRef = ref(null);
const formLnameRef = ref(null);
const formPhotoRef = ref(null);
const formPhoneRef = ref(null);
const formCityRef = ref(null);
const formAddressRef = ref(null);
const formZipRef = ref(null);

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
