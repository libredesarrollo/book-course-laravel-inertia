<template>

<o-modal v-model:active="confirmDeleteActive">
        <p class="p-4">Are you sure you want to delete the selected record?</p>
        <div class="flex flex-row-reverse p-3 bg-gray-100 gap-3">
            <o-button @click="deletePost()" variant="danger">Delete</o-button>
            <o-button @click="confirmDeleteActive=false">Cancel</o-button>
        </div>
    </o-modal>

    <app-layout>
        <div class="container">
            <Link class="link-button-default my-3" :href="route('post.create')">Create</Link>

            <div class="card">
                <div class="card-body">
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3">Id</th>
                                <th class="p-3">Title</th>
                                <th class="p-3">Slug</th>
                                <th class="p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="p in posts.data" :key="p.id">
                                <td class="p-2">{{ p.id }}</td>
                                <td class="p-2">{{ p.title }}</td>
                                <td class="p-2">{{ p.slug }}</td>
                                <td class="p-2">
                                    <Link class="mr-2 text-sm text-purple-400 hover:text-purple-700"
                                        :href="route('post.edit', p)">Edit</Link>
                                        <o-button variant="danger" size="small" @click="confirmDeleteActive=true; deletePostRow=p.id">Delete</o-button>
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

export default {
    components: {
        AppLayout,
        Link,
        Pagination
    },
    props: {
        posts: Object
    },
    data() {
        return {
            confirmDeleteActive: false,
            deletePostRow: ""
        }
    },
    methods: {
        deletePost() {
            router.delete(route('post.destroy', this.deletePostRow))
            this.confirmDeleteActive = false
        }
    },
}   
</script>
