<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <o-modal v-model:active="confirmDeleteActive">
            <p class="p-4 text-black">Are you sure you want to delete the selected record?</p>

            <div class="flex flex-row-reverse gap-2 bg-gray-100 p-3">
                <o-button variant="danger" @click="deleteCategory">Delete</o-button>
                <o-button @click="confirmDeleteActive = false">Cancel</o-button>
            </div>
        </o-modal>

        <Link class="link-button-default mx-4 my-3" :href="route('category.create')">Create</Link>

        <div class="mx-4">
            <table class=" w-full border">
                <thead class="dark:bg-gray-800 bg-gray-100">
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
                            <Link class="text-sm text-purple-400 hover:text-purple-700"
                                :href="route('category.edit', c.id)">
                            Edit</Link>
                            <!-- <Link as="button" type="button" method="DELETE"
                                class="text-sm text-red-400 hover:text-red-700 ml-2"
                                :href="route('category.destroy', c.id)" >Delete</Link> -->

                            <o-button iconLeft="delete" rounded size="small" variant="danger"
                                @click=" confirmDeleteActive = true; deleteCategoryRow = c.id;">Delete</o-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <pagination :links="categories" />
    </AppLayout>
</template>

<script>

import { Link, router } from "@inertiajs/vue3"
import AppLayout from '@/layouts/AppLayout.vue';
import Pagination from '@/shared/Pagination.vue';

export default {
    props: {
        categories: Object
    },
    components: {
        Pagination,
        AppLayout,
        Link
    },
    data() {
        return {
            confirmDeleteActive: false,
            deleteCategoryRow: "",
        };
    },
    methods: {
        deleteCategory() {
            this.$inertia.delete(route('category.destroy', this.deleteCategoryRow));
            this.confirmDeleteActive = false;
        }
    },
    setup() {

        const breadcrumbs = [
            {
                title: 'Categories',
                // href: '/dashboard/category',
            },
        ];

        return {
            breadcrumbs
        };
    }
}
</script>