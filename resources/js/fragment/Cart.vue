<template>
    <div class="mb-3" v-for="c in $page.props.cart" :key="c">
        <CartItem :post="c[0]" :pcount="c[1].toString()" :active='myItemId == c[0].id' />
    </div>
</template>
<script>

// import { router } from "@inertiajs/vue3"
import CartItem from "@/Fragment/CartItem.vue";

export default {

    components: {
        CartItem,
    },
    props: {
        myItemId: {
            type: Number,
            default: 0,
        }
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