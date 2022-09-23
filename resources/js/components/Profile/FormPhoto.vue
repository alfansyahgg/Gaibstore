<template>
    <n-form-item
        label="Photo"
        :label-props="{ class: 'font-medium' }"
        :path="path"
    >
        <input
            ref="inputFileRef"
            class="hidden"
            type="file"
            accept=".png, .jpeg, .jpg"
            @input="handleInput"
        />
        <div class="flex items-center gap-4">
            <n-spin :show="previewLoading">
                <img
                    width="100"
                    :src="previewImage || imageAvatar"
                    :fallback-src="imageAvatar"
                    class="!cursor-pointer"
                    @click="chooseFile"
                />
            </n-spin>
            <div class="flex flex-col">
                <h3 class="font-semibold text-primary-500">Upload Photo</h3>
                <p class="text-gray-500 text-xs">
                    An image of the person, it's best if it has the same length
                    and height
                </p>
            </div>
        </div>
    </n-form-item>
</template>
<script setup>
import imageAvatar from "@images/avatar.png";
const props = defineProps({
    photo: {
        type: Object,
        default: null,
    },
    path: {
        type: String,
        default: "photo",
    },
    preview: {
        type: String,
        default: null,
    },
});
const emit = defineEmits(["update:photo"]);

const value = computed({
    get() {
        return props.photo;
    },
    set(value) {
        emit("update:photo", value);
    },
});

// Allowing file type
var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

const inputFileRef = ref(null);
const previewImage = ref(props.preview);
const previewLoading = ref(false);

const chooseFile = () => {
    inputFileRef.value?.click();
};

function handleInput(event) {
    value.value = event.target.files[0];
}

watch(value, (newValue) => {
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

const rule = {
    type: "object",
    trigger: ["input", "blur", "change"],
    validator: (rule, value) => {
        if (
            value &&
            !allowedExtensions.exec(`.${value.name.split(".")?.pop()}`)
        ) {
            return new Error("Sorry, only JPG, JPEG & PNG files are allowed.");
        }

        return true;
    },
};

defineExpose({
    rule,
});
</script>
