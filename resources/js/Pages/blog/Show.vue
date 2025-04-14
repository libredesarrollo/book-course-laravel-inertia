<template>
    <web-layout>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <img class="w-full rounded-md shadow-md my-4 max-w-80 mx-auto" style="max-width:500px"
                        :src="post.image ? '/image/post/' + post.image : '/image/default.jpg'" alt="" />

                    <h4 class="text-center text-5xl mb-3">{{ post.title }}</h4>

                    <p class="my-4 ml-2">
                        <span class="
                  text-sm text-gray-500
                  italic
                  font-bold
                  uppercase
                  tracking-widest
                ">{{ post.date }}</span>
                        <span class="ml-4 rounded-md bg-purple-500 py-1 px-2 text-gray-800">{{
                            post.category.title
                            }}</span>
                        <span class="ml-4 rounded-md bg-purple-500 py-1 px-2 text-gray-800">{{
                            post.type
                            }}</span>
                    </p>


                    <div v-html="post.text" class="my-5"></div>

                    <template v-if="post.type == 'advert'">
                        <div class="mycard mb-5 ms-auto block max-w-96">
                            <div class="mycard-body">
                                <h3 class="text-xl mb-3 ml-4">My products</h3>
                                <cart :myItemId="post.id" />
                            </div>
                        </div>
                        <transition name="fade-slide">
                            <div class="mycard-primary mb-5 block max-w-96" v-if="$page.props.cart[post.id] == null">
                                <div class="mycard-body">
                                    <h3 class="text-xl mb-3 ml-4">Add this item</h3>
                                    <cart-item :post="post" />
                                </div>
                            </div>
                        </transition>
                    </template>

                    <hr />
                    <br>

                    <!-- <GeneralStep :errors="errors" /> -->
                </div>
            </div>
        </div>
    </web-layout>
</template>

<script>

import WebLayout from "@/Layouts/WebLayout.vue";
import GeneralStep from "@/Pages/Contact/General/Step.vue";
import Cart from "@/fragment/Cart.vue";
import CartItem from '@/fragment/CartItem.vue';

export default {
    data() {
        return {};
    },
    components: {
        WebLayout,
        GeneralStep,
        Cart,
        CartItem
    },
    props: {
        post: Object,
        errors: Object,
    },
};
</script>

<style>
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.4s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(20px);
}

.fade-slide-enter-to,
.fade-slide-leave-from {
    opacity: 1;
    transform: translateY(0);
}
</style>