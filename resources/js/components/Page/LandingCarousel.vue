<template>
    <n-carousel show-arrow autoplay trigger="hover" draggable>
        <div class="carousel-item bg-carousel flex justify-center">
            <div
                class="carousel-text flex flex-col justify-center h-full w-1/2"
            >
                <h3 class="font-semibold text-3xl text-primary-500">
                    Gaib Store
                </h3>
                <p class="text-lg">Perfect Place to Shopping</p>
                <p class="text-sm">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
            <img class="carousel-img" src="@images/banner_img_01.jpg" />
        </div>
        <div class="carousel-item bg-carousel flex justify-center">
            <div
                class="carousel-text flex flex-col justify-center h-full w-1/2"
            >
                <h3 class="font-semibold text-3xl text-primary-500">
                    Gaib Store
                </h3>
                <p class="text-lg">Perfect Place to Shopping</p>
                <p class="text-sm">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
            <img class="carousel-img" src="@images/banner_img_02.jpg" />
        </div>

        <div class="carousel-item bg-carousel flex justify-center">
            <div
                class="carousel-text flex flex-col justify-center h-full w-1/2"
            >
                <h3 class="font-semibold text-3xl text-primary-500">
                    Gaib Store
                </h3>
                <p class="text-lg">Perfect Place to Shopping</p>
                <p class="text-sm">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
            <img class="carousel-img" src="@images/banner_img_03.jpg" />
        </div>

        <template #dots="{ total, currentIndex, to }">
            <ul class="custom-dots">
                <li
                    v-for="index of total"
                    :key="index"
                    :class="{ ['is-active']: currentIndex === index - 1 }"
                    @click="to(index - 1)"
                />
            </ul>
        </template>
    </n-carousel>
</template>

<style scoped>
@media only screen and (max-width: 640px) {
    .carousel-item {
        flex-direction: column;
        height: auto;
    }
    .carousel-img {
        display: none;
    }
    .carousel-text {
        width: 100%;
        text-align: center;
    }
}

.carousel-item {
    width: 100%;
    height: 500px;
    object-fit: cover;
}

.carousel-img {
    padding: 50px;
}

.custom-dots {
    display: flex;
    margin: 0;
    padding: 0;
    position: absolute;
    bottom: 20px;
    left: 20px;
}

.custom-dots li {
    display: inline-block;
    width: 12px;
    height: 4px;
    margin: 0 3px;
    border-radius: 4px;
    background-color: rgba(114, 113, 113, 0.659);
    transition: width 0.3s, background-color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.custom-dots li.is-active {
    width: 40px;
    background: #10b981;
}
</style>
