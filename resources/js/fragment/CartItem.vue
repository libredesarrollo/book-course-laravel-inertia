<template>
    <div class="flex flex-row gap-2 items-end">
        <div>
            <Label :class='{ "text-red-800":active }' class="mt-4 ms-4">{{ this.post.title.substr(0,15) }}...</Label>
            <Input v-model="count" type="number" />
        </div>
        <Button class="mb-1" size="sm" @click="submit">Send</Button>
    </div>
</template>
<script>

import { router } from "@inertiajs/vue3"

import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
// import Input from '@/Components/Input.vue';
import Input from '@/components/ui/input/Input.vue';

import { toRaw } from 'vue'

export default {
    components: {
        Button,
        Label,
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
        active: {
            type: Boolean,
            default: false,
        }
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
