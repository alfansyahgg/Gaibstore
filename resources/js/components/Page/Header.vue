<template>
    <div class="flex items-center justify-between w-full h-full">
        <base-title class="text-primary-500 w-full sm:w-1/5"></base-title>
        <div class="navs hidden sm:flex gap-x-10 text-black" style="width: 40%">
            <base-link :href="$route('welcome.index')"> Home </base-link>
            <base-link :href="$route('welcome.about')"> About </base-link>
            <base-link :href="$route('welcome.shop')"> Shop </base-link>
            <base-link :href="$route('welcome.contact')"> Contact </base-link>
        </div>
        <div class="menus flex gap-3 sm:gap-x-6">
            <n-badge
                :value="myCart ? Object.keys(myCart).length : 0"
                @click="drawerRef = true"
            >
                <n-avatar class="!bg-transparent">
                    <n-icon class="!text-primary-500 cursor-pointer">
                        <cart></cart>
                    </n-icon>
                </n-avatar>
            </n-badge>

            <base-link
                v-if="$page.props.auth.user == null"
                :href="$route('auth.login')"
            >
                <n-button type="primary" size="medium">Sign In </n-button>
            </base-link>
            <base-link
                v-else
                :href="$route('profile.index')"
                class="!hidden sm:!block"
            >
                <n-button type="primary" size="medium">
                    <template #icon>
                        <n-icon>
                            <person />
                        </n-icon>
                    </template>
                    My Profile
                </n-button>
            </base-link>
            <base-link
                v-if="$page.props.auth.user != null"
                class="!block sm:!hidden"
                :href="$route('profile.index')"
            >
                <n-avatar class="!bg-transparent">
                    <n-icon class="!text-primary-500 cursor-pointer">
                        <person />
                    </n-icon>
                </n-avatar>
            </base-link>

            <drawer-cart
                v-model:drawer="drawerRef"
                v-model:cart="myCart"
            ></drawer-cart>
        </div>
    </div>
</template>
<script setup>
import { Search, Cart, Person } from "@vicons/ionicons5";
const myCart = computed(() => inject("$page").value.props.cart[0]);
console.log(myCart.value);

// ref
const drawerRef = ref(false);
</script>
