<template>
    <div class="mb-3" v-for="c in $page.props.cart" :key="c">
        <!-- <input v-model="c[1]" type="number" class="w-20" @keyup.enter="submit(c)"> {{ c[0].title }} -->
        <CartItem :post="c[0]" :pcount="c[1].toString()" />
    </div>
</template>
<script>

// import { router } from "@inertiajs/vue3"
import CartItem from "@/Fragment/CartItem.vue";

export default {

    components: {
        CartItem,
    },
    // methods: {
    //     submit(c) {

    //         router.post(route("shop.add", {
    //             post: c[0].id,
    //             count: c[1]
    //         }))

    //         this.$oruga.notification.open({
    //             message: 'Applied changes',
    //             position: 'top-right',
    //             variant: 'success',
    //             duration: 2000,
    //             closable: true
    //         })

    //     }
    // }
}
</script>