<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <o-modal v-model:active="confirmDeleteActive">
            <p class="p-4 text-black">Are you sure you want to delete the record?</p>

            <div class="flex flex-row-reverse gap-2 bg-gray-100 p-3">
                <o-button variant="danger" @click="deletePost">Delete</o-button>
                <o-button @click="confirmDeleteActive = false">Cancel</o-button>
            </div>
        </o-modal>

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
                            <!-- <Link as="button" type="button" method="DELETE"
                                class="text-sm text-red-400 hover:text-red-700 ml-2"
                                :href="route('post.destroy', p.id)">Delete</Link> -->
                            <!-- <o-button iconLeft="delete" rounded size="small" variant="danger" @click="confirmDeleteActive = true;
                            deletePostRow = p.id;">Delete</o-button> -->

                            <Dialog>
                                <DialogTrigger as-child>
                                    <Button class="ml-2" variant="destructive" size="sm">
                                        Delete
                                    </Button>
                                </DialogTrigger>
                                <DialogContent>
                                    <DialogHeader>
                                        <DialogTitle>
                                            Are you sure you want to delete the record?
                                        </DialogTitle>
                                        <DialogDescription>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere laborum
                                            omnis s
                                        </DialogDescription>
                                    </DialogHeader>
                                    <DialogFooter>
                                        <DialogClose as-child>
                                            <Button variant="secondary">
                                                Cancel
                                            </Button>
                                        </DialogClose>
                                        <DialogClose as-child>
                                            <Button variant="destructive" @click="deletePost(p)">
                                                Delete
                                            </Button>
                                        </DialogClose>

                                    </DialogFooter>
                                </DialogContent>
                            </Dialog>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <pagination class="my-4" :links="posts" />
    </AppLayout>
</template>

<script>

import { Link, router } from "@inertiajs/vue3"
import AppLayout from '@/layouts/AppLayout.vue';
import Pagination from '@/shared/Pagination.vue';

import { Button } from '@/components/ui/button';

import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

export default {
    data() {
        return {
            confirmDeleteActive: false,
            deletePostRow: "",
        };
    },
    methods: {
        // deletePost() {
        //     router.delete(route("post.destroy", this.deletePostRow));
        //     this.confirmDeleteActive = false;
        // },
        deletePost(post) {
            router.delete(route("post.destroy", post.id));
        },
    },
    props: {
        posts: Object
    },
    components: {
        Pagination,
        AppLayout,
        Link,
        Button,
        Dialog,
        DialogClose,
        DialogContent,
        DialogDescription,
        DialogFooter,
        DialogHeader,
        DialogTitle,
        DialogTrigger,

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