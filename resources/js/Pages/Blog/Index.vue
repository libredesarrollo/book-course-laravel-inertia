<script>

import { Link, router } from "@inertiajs/vue3"

import WebLayout from '@/Layouts/WebLayout.vue';
import Pagination from '@/Shared/Pagination.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: {
        WebLayout,
        Link,
        Pagination,
        PrimaryButton,
        SecondaryButton,
        TextInput
    },
    props: {
        posts: Object,
        categories: Array,
        prop_category_id: String,
        prop_type: String,
        prop_from: String,
        prop_to: String,
        prop_search: String,
    },
    data() {
        return {
            category_id: this.prop_category_id,
            type: this.prop_type,
            from: this.prop_from,
            to: this.prop_to,
            search: this.prop_search,
        }
    },
    methods: {
        cleanFilter() {
            router.get(route('web.index'))
        },
        customSearch() {
            router.get(route('web.index', {
                category_id: this.category_id,
                type: this.type,
                from: this.from,
                to: this.to,
                search: this.search,
            }))
        }
    },
}   
</script>

<template>
    <WebLayout>
        <section>
            <div class="card">
                <div class="card-body">

                    <div class="grid grid-cols-2 gap-2 mb-3">
                        <!-- <TextInput autofocus @keyup="customSearch" class="w-full" type="text" placeholder="Search..." v-model="search" /> -->
                        <TextInput autofocus v-debounce.500ms="customSearch" :debounce-events="['keyup']" class="w-full"
                            type="text" placeholder="Search..." v-model="search" />

                        <select @change="customSearch" class="rounded w-full border-gray-300" v-model="type">
                            <option :value="null">Type</option>
                            <option value="advert">Advert</option>
                            <option value="post">Post</option>
                            <option value="course">Course</option>
                            <option value="movie">Movie</option>
                        </select>
                        <select @change="customSearch" class="rounded w-full border-gray-300" v-model="category_id">
                            <option :value="null">Category</option>
                            <option v-for="c in categories" :value="c.id" :key="c">{{ c.title }}</option>
                        </select>

                        <TextInput class="w-full" type="date" placeholder="Date From" v-model="from" />
                        <TextInput class="w-full" @change="customSearch" type="date" placeholder="Date To"
                            v-model="to" />

                        <div>
                            <PrimaryButton @click="customSearch">
                                Filter
                            </PrimaryButton>

                            <SecondaryButton class="ml-3" @click="cleanFilter">
                                Clear
                            </SecondaryButton>

                        </div>
                    </div>

                </div>
            </div>


            <!-- item -->
            <div class="flex flex-col items-center mt-5">
                <div class="w-full sm:max-w-4xl overflow-hidden">
                    <div v-for="p in posts.data" class="p-3" :key="p">
                        <h4 class="text-center text-4xl mb-3">{{ p.title }}</h4>
                        <p class="
                              text-center text-sm text-gray-500
                              italic
                              font-bold
                              uppercase
                              tracking-widest
                            ">
                            {{ p.date }}
                        </p>


                        <img class="w-full rounded-md shadow-md my-4"
                            :src="p.image ? 'image/post/' + p.image : '/image/default.jpg'" alt="">


                        <p class="mx-4">{{ p.description }}</p>


                        <div class="flex flex-col items-center mt-7">
                            <a class="btn-primary" :href="route('web.show', p.slug)">Read more!</a>
                        </div>


                        <hr class="my-16">

                    </div>
                </div>
            </div>

            <!-- item -->


            <pagination class="my-4" :links="posts.links" />
        </section>

    </WebLayout>
</template>