<template lang="">
    <n-layout position="absolute">
        <slot />
    </n-layout>
</template>
<script setup>
    import { useLoadingBar, useMessage, useNotification, useDialog } from "naive-ui";
	
    const loadingBar = useLoadingBar();
    // Loading Start
	document.addEventListener("inertia:start", () => {
		loadingBar.start();
	});
	// Loading Finish
	document.addEventListener("inertia:finish", (event) => {
		if (event.detail.visit.completed) {
			loadingBar.finish();
		} else {
			loadingBar.error();
		}
	});

	provide("$loadingBar", loadingBar);
</script>
<style>
    
</style>