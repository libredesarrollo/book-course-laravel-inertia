<template>
    <web-layout>
        <div class="mycard mx-auto block mt-10">
            <div class="mycard-body">
                <h3 class="text-4xl text-center mb-10">Shopping</h3>
                <cart />
            </div>
        </div>
    </web-layout>
</template>

<script>
import Cart from '@/Fragment/Cart.vue';
import WebLayout from '@/Layouts/WebLayout.vue';

export default {
    components: {
        WebLayout,
        Cart
    }
}
</script>