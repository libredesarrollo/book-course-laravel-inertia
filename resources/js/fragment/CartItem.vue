<template>
    <Input v-model="count" type="number"/>
    <Button @click="submit">Send</Button>
</template>
<script>

import { router } from "@inertiajs/vue3"

import { Button } from '@/components/ui/button';
// import Input from '@/Components/Input.vue';
import Input from '@/components/ui/input/Input.vue';

import { toRaw } from 'vue'

export default {
    components: {
        Button,
        Input
    },
    mounted() {
        // console.log(toRaw(this.$page.props.cart))
        // console.log(Object.keys(this.$page.props.cart))
        let n = 0
        Object.keys(this.$page.props.cart).forEach((k) => {
            // console.log(this.$page.props.cart[k][1])
            n += this.$page.props.cart[k][1]
        })
    },
    data() {
        return {
            count: this.pcount,
        }
    },
    props: {
        post: {
            required: true,
            type: Object
        },
        pcount: {
            type: String,
            default: "1",
        },
    },
    methods: {
        submit() {
            router.post(route("shop.add", {
                post: this.post.id,
                count: this.count
            }))

            this.$oruga.notification.open({
                message: 'Applied changes',
                position: 'top-right',
                variant: 'success',
                duration: 2000,
                closable: true
            })

        }
    }
}
</script>
