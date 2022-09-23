<template>
    <n-form-item 
        path="password" 
        label="Password"
        :required="true"
    >
        <n-input 
            v-model:value="passwordModel"
            type="password"
            show-password-on="click"
            @keydown.enter.prevent
        />
    </n-form-item>
</template>
<script setup>

    const props = defineProps({
        password: {
            type: String,
            default: () => {}
        }
    })

    const emit = defineEmits([
        'update:password'
    ])

    const passwordModel = computed({
        get() {
            return props.password
        },
        set(value) {
            emit('update:password', value)
        }
    })

    const rule = {
        trigger: ["input", "blur"],
        required: true,
        message: "Please input password...",
    }

    defineExpose({
        rule,
    })

</script>