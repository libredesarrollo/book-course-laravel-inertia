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

                    <hr />
                    <br>

                    <GeneralStep :errors="errors" />
                </div>
            </div>
        </div>
    </web-layout>
</template>
http://inertiastore.test/contact/contact-general/13/edit
<script>
import WebLayout from "@/Layouts/WebLayout.vue";
import GeneralStep from "@/Pages/Contact/General/Step.vue";

export default {
    data() {
        return {};
    },
    components: {
        WebLayout,
        GeneralStep
    },
    props: {
        post: Object,
        errors: Array,
    },
};
</script>