<template>
    <div
        class="about-jumbo flex flex-col sm:flex-row items-center justify-center p-4 sm:p-20 bg-primary-500"
    >
        <div class="about-text flex flex-col w-full sm:w-1/2">
            <h1 class="text-white font-semibold text-3xl">About Us</h1>
            <p class="text-white text-sm">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat.
            </p>
        </div>
        <div class="about-image flex w-full sm:w-1/2">
            <img class="item-image" src="@images/about-hero.svg" />
        </div>
    </div>
</template>
<script setup></script>
<style scoped>
.about-jumbo {
    height: 500px;
}

.item-image {
    width: 100%;
    height: 300px;
}
@media only screen and (max-width: 640px) {
    .item-image {
        width: 100%;
        height: 200px;
    }
}
</style>