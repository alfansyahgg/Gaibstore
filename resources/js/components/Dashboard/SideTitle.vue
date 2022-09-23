<template>
    <div>
        <h3 class="text-3xl text-primary-500 text-center">{{ title }}</h3>
    </div>
</template>
<script setup>
const props = defineProps(["collapsed"]);
const title = ref('Gaibstore')
watch(
    () => props.collapsed,
    (col, preCol) => {
        console.log(col)
        title.value = col ? 'Gaib': 'Gaibstore';
    }
);
</script>