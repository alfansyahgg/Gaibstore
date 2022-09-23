<template>
    <div v-for="item in values" :key="item.id" class="cart-item border-b flex">
        <div class="w-2/4 flex">
            <div class="img">
                <img
                    :src="item.photo || item.preview"
                    style="height: 100px"
                    alt=""
                />
            </div>
            <div class="text">
                <h3 class="font-semibold text-lg">{{ item.name }}</h3>
                <p>{{ item.brand }}</p>
                <p>{{ item.color }} - Size {{ item.size }}</p>
            </div>
        </div>
        <div class="w-1/4">
            <div>
                <h3 class="font-semibold">Quantity</h3>
                <h3>x{{ item.quantity }}</h3>
            </div>
        </div>
        <div class="w-1/4">
            <div>
                <h3 class="font-semibold">Price</h3>
                <h3>Rp. {{ item.price.toLocaleString("id-ID") }}</h3>
            </div>
        </div>
    </div>
</template>
<script setup>
// props
const props = defineProps({
    cart: {
        type: Object,
        default: () => {},
    },
});

const values = computed(() => props.cart);
</script>
