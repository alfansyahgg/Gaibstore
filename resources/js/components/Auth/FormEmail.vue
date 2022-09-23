<template>
    <n-form-item 
        path="email" 
        label="Email"
        :required="true"
    >
        <n-input 
            v-model:value="emailModel"
            placeholder="Email Address..."
            show-count
            @keydown.enter.prevent
        />
    </n-form-item>
</template>
<script setup>

    const props = defineProps({
        email: {
            type: String,
            default: () => {}
        }
    })

    const emit = defineEmits([
        'update:email'
    ])

    const emailModel = computed({
        get() {
            return props.email
        },
        set(value) {
            emit('update:email', value)
        }
    })

    const rule = {
        trigger: ["input", "blur"],
        required: true,
        message: "Please input email...",
    }

    defineExpose({
        rule,
    })

</script>