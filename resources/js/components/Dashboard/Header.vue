<template>
    <div class="flex items-center justify-between w-full">
        <base-link :href="$route('welcome.index')">
            <div class="title">
                <h3 class="text-2xl text-white font-semibold">Gaibstore</h3>
            </div>
        </base-link>
        <div class="menus">
            <h3 class="text-sm text-white font-semibold">
                {{ $page.props.auth.user.email }} |
                {{ $page.props.auth.user.role }}
            </h3>
        </div>
    </div>
</template>
<script setup>
const page = inject("$page").value.props;
</script>
