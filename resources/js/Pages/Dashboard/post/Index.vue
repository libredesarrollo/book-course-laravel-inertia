<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Link class="link-button-default mx-4  my-3" :href="route('post.create')">Create</Link>

        <div class="mx-4">
            <table class="w-full border">
                <thead class="dark:bg-gray-800 bg-gray-100">
                    <tr class="border-b">
                        <th class="p-3">Id</th>
                        <th class="p-3">Title</th>
                        <th class="p-3">Slug</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b" v-for="p in posts.data" :key="p.id">
                        <td class="p-2">{{ p.id }}</td>
                        <td class="p-2">{{ p.title }}</td>
                        <td class="p-2">{{ p.slug }}</td>
                        <td class="p-2">
                            <Link class="text-sm text-purple-400 hover:text-purple-700"
                                :href="route('post.edit', p.id)">Edit</Link>
                            <Link as="button" type="button" method="DELETE"
                                class="text-sm text-red-400 hover:text-red-700 ml-2"
                                :href="route('post.destroy', p.id)">Delete</Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <pagination class="my-4" :links="posts" />
    </AppLayout>
</template>

<script>

import { Link } from "@inertiajs/vue3"
import AppLayout from '@/layouts/AppLayout.vue';
import Pagination from '@/shared/Pagination.vue';

export default {
    props: {
        posts: Object
    },
    components: {
        Pagination,
        AppLayout,
        Link
    },
    setup() {

        const breadcrumbs = [
            {
                title: 'Posts',
                // href: '/dashboard/category',
            },
        ];

        return {
            breadcrumbs
        };
    }
}
</script>