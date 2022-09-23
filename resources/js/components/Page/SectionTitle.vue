<template>
    <div class="top text-center w-full sm:w-1/2 mx-auto py-4">
        <h3 class="text-5xl font-extralight">
            <slot name="title" />
        </h3>
        <p class="text-lg mt-2">
            <slot name="desc" />
        </p>
    </div>
</template>