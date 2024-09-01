<template>
    <confirmation-modal :show="confirmDeleteActive">
        <template v-slot:title>
            Confirmation
        </template>

        <template v-slot:content>
            <p>Are you sure you want to delete the selected record?</p>
        </template>

        <template v-slot:footer>
            <div class="flex flex-row-reverse bg-gray-100 gap-3">
                <o-button @click="deleteCategory()" variant="danger">Delete</o-button>
                <o-button @click="confirmDeleteActive = false">Cancel</o-button>
            </div>
        </template>
    </confirmation-modal>

    <!-- <o-modal v-model:active="confirmDeleteActive">
        <p class="p-4">Are you sure you want to delete the selected record?</p>
        <div class="flex flex-row-reverse p-3 bg-gray-100 gap-3">
            <o-button @click="deleteCategory()" variant="danger">Delete</o-button>
            <o-button @click="confirmDeleteActive=false">Cancel</o-button>
        </div>
    </o-modal> -->


    <app-layout>
        <div class="container">
            <Link class="link-button-default my-3" :href="route('category.create')">Create</Link>

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
                            <tr v-for="c in categories.data" :key="c.id">
                                <td class="p-2">{{ c.id }}</td>
                                <td class="p-2">{{ c.title }}</td>
                                <td class="p-2">{{ c.slug }}</td>
                                <td class="p-2">
                                    <Link class="mr-3 text-sm text-purple-400 hover:text-purple-700"
                                        :href="route('category.edit', c)">Edit</Link>

                                    <o-button variant="danger" size="small"
                                        @click="confirmDeleteActive = true; deleteCategoryRow = c.id">Delete</o-button>

                                    <!-- <Link as="button" type="button" method="DELETE"
                                        class="text-sm text-red-400 hover:text-red-700 ml-2"
                                        :href="route('category.destroy', c)">Delete</Link> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <pagination :links="categories.links" />
        </div>
    </app-layout>
</template>
<script>

import { Link, router } from "@inertiajs/vue3"

import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Shared/Pagination.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';

export default {
    components: {
        AppLayout,
        Link,
        Pagination,
        ConfirmationModal
    },
    props: {
        categories: Object
    },
    data() {
        return {
            confirmDeleteActive: false,
            deleteCategoryRow: ""
        }
    },
    methods: {
        deleteCategory() {
            router.delete(route('category.destroy', this.deleteCategoryRow))
            this.confirmDeleteActive = false
        }
    },
}   
</script>
