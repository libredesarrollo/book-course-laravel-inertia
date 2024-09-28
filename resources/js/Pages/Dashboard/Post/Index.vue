<template>

    <o-modal v-model:active="confirmDeleteActive">
        <p class="p-4">Are you sure you want to delete the selected record?</p>
        <div class="flex flex-row-reverse p-3 bg-gray-100 gap-3">
            <o-button @click="deletePost()" variant="danger">Delete</o-button>
            <o-button @click="confirmDeleteActive = false">Cancel</o-button>
        </div>
    </o-modal>

    <app-layout>
        <div class="container">
            <Link class="link-button-default my-3" :href="route('post.create')">Create</Link>

            <div class="card">
                <div class="card-body">

                    <div class="grid grid-cols-2 gap-2 mb-3">
                        <!-- <TextInput autofocus @keyup="customSearch" class="w-full" type="text" placeholder="Search..." v-model="search" /> -->
                        <TextInput autofocus v-debounce.500ms="customSearch" :debounce-events="['keyup']" class="w-full" type="text" placeholder="Search..." v-model="search" />

                        <select @change="customSearch" class="rounded w-full border-gray-300" v-model="posted">
                            <option :value="null">Posted</option>
                            <option value="not">Not</option>
                            <option value="yes">Yes</option>
                        </select>
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
                        <TextInput class="w-full" @change="customSearch" type="date" placeholder="Date To" v-model="to" />

                        <div>
                        <PrimaryButton @click="customSearch">
                            Filter
                        </PrimaryButton>
                        </div>
                    </div>

                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3">Id</th>
                                <th class="p-3">Title</th>
                                <th class="p-3">Date</th>
                                <th class="p-3">Posted</th>
                                <th class="p-3">Category</th>
                                <th class="p-3">Description</th>
                                <th class="p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="p in posts.data" :key="p.id">
                                <td class="p-2 text-center">{{ p.id }}</td>
                                <td class="p-2 text-center">{{ p.title.substring(0, 15) }}</td>
                                <td class="p-2 text-center">{{ p.date }}</td>
                                <td class="p-2 text-center">{{ p.posted }}</td>
                                <td class="p-2 text-center">{{ p.category.title }}</td>
                                <td class="p-2 text-center">
                                    <textarea class="w-48 block m-auto">
                                    {{ p.description }}
                                </textarea>
                                </td>
                                <td class="p-2">
                                    <Link class="mr-2 text-sm text-purple-400 hover:text-purple-700"
                                        :href="route('post.edit', p)">Edit</Link>
                                    <o-button variant="danger" size="small"
                                        @click="confirmDeleteActive = true; deletePostRow = p.id">Delete</o-button>
                                    <!-- <Link as="button" type="button" method="DELETE"
                                        class="text-sm text-red-400 hover:text-red-700 ml-2"
                                        :href="route('post.destroy', p)">Delete</Link> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <pagination :links="posts.links" />
        </div>
    </app-layout>
</template>
<script>

import { Link, router } from "@inertiajs/vue3"

import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Shared/Pagination.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

export default {
    components: {
        AppLayout,
        Link,
        Pagination,
        PrimaryButton,
        TextInput
    },
    props: {
        posts: Object,
        categories: Array,
        prop_category_id: String,
        prop_posted: String,
        prop_type: String,
        prop_from: String,
        prop_to: String,
        prop_search: String,
    },
    data() {
        return {
            confirmDeleteActive: false,
            deletePostRow: "",
            category_id: this.prop_category_id,
            posted: this.prop_posted,
            type: this.prop_type,
            from: this.prop_from,
            to: this.prop_to,
            search: this.prop_search,
        }
    },
    methods: {
        deletePost() {
            router.delete(route('post.destroy', this.deletePostRow))
            this.confirmDeleteActive = false
        },
        customSearch() {
            router.get(route('post.index', {
                category_id: this.category_id,
                type: this.type,
                posted: this.posted,
                from: this.from,
                to: this.to,
                search: this.search,
            }))
        }
    },
}   
</script>
