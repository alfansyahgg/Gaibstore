<template>
    <div class="sidebar flex flex-col gap-8">
        <dashboard-side-menus :collapsed="collapsed"></dashboard-side-menus>
    </div>
</template>
<script setup>
const props = defineProps(["collapsed"]);
</script>