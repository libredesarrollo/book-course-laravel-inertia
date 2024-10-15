<template>
    <web-layout>
        <div class="card">
            <div class="card-body">
                <h3>Shopping</h3>
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