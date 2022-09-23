<template>
    <div class="brand-item w-1/2">
        <n-carousel :loop="false" draggable slides-per-view="2" show-arrow>
            <div class="carousel-item flex items-center justify-center">
                <img class="carousel-img" src="@images/brands/brand_01.png" />
            </div>
            <div class="carousel-item flex items-center justify-center">
                <img class="carousel-img" src="@images/brands/brand_02.png" />
            </div>
            <div class="carousel-item flex items-center justify-center">
                <img class="carousel-img" src="@images/brands/brand_03.png" />
            </div>
            <div class="carousel-item flex items-center justify-center">
                <img class="carousel-img" src="@images/brands/brand_04.png" />
            </div>
            <template #arrow="{ prev, next }">
                <div class="custom-arrow">
                    <button
                        type="button"
                        class="curtom-arrow--left"
                        @click="prev"
                    >
                        <n-icon><ArrowBack /></n-icon>
                    </button>
                    <button
                        type="button"
                        class="curtom-arrow--right"
                        @click="next"
                    >
                        <n-icon><ArrowForward /></n-icon>
                    </button>
                </div>
            </template>
        </n-carousel>
    </div>
</template>
<script setup>
import { ArrowBack, ArrowForward } from "@vicons/ionicons5";
</script>
<style scoped>
.carousel-item {
    width: 100%;
    height: 240px;
    object-fit: cover;
}

.carousel-img {
    height: 50%;
}

.custom-arrow {
    display: flex;
    justify-content: center;
    position: absolute;
    bottom: 0;
    left: 40%;
    right: 40%;
}

.custom-arrow button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    margin-right: 12px;
    color: #fff;
    background-color: #10b981;
    border-width: 0;
    border-radius: 8px;
    transition: background-color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.custom-arrow button:hover {
    background-color: #10b981;
}

.custom-arrow button:active {
    transform: scale(0.95);
    transform-origin: center;
}
</style>