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

            <div class="grid grid-cols-2 gap-2 mb-2">
                <select @change="customSearch" class="rounded-md w-full border-gray-300" v-model="posted">
                    <option :value="null">Posted</option>
                    <option value="not">No</option>
                    <option value="yes">Yes</option>
                </select>


                <select @change="customSearch" class="rounded-md w-full border-gray-300" v-model="type">
                    <option :value="null">Type</option>
                    <option value="advert">Advert</option>
                    <option value="post">Post</option>
                    <option value="course">Course</option>
                    <option value="movie">Movie</option>
                </select>


                <select @change="customSearch" class="rounded-md w-full border-gray-300" v-model="category_id">
                    <option :value="null">Category</option>
                    <option v-for="c in categories" :value="c.id" :key="c.id">
                        {{ c.title }}
                    </option>
                </select>
                <Input type="text" placeholder="Search..." v-model="search" />
                <Input type="date" placeholder="Date From" v-model="from" />
                <Input @change="customSearch"  type="date" placeholder="Date To" v-model="to" />

                <Button @click="customSearch">
                    Filter
                </Button>
                <Button variant="secondary" class="ml-3" @click="cleanSearch">
                    Clear
                </Button>

            </div>


            <table class="w-full border">
                <thead class="dark:bg-gray-800 bg-gray-100">
                    <tr class="border-b">
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
                    <tr class="border-b" v-for="p in posts.data" :key="p.id">
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
import Input from '@/components/ui/input/Input.vue';

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
            type: this.prop_type,
            category_id: this.prop_category_id,
            posted: this.prop_posted,
            search: this.prop_search,
            from: this.prop_from,
            to: this.prop_to,
        };
    },
    props: {
        posts: Object,
        categories: Object,
        prop_type: String,
        prop_category_id: String,
        prop_posted: String,
        prop_search: String,
        prop_from: String,
        prop_to: String,
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
        Input
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
    },
    methods: {
        // deletePost() {
        //     router.delete(route("post.destroy", this.deletePostRow));
        //     this.confirmDeleteActive = false;
        // },
        deletePost(post) {
            router.delete(route("post.destroy", post.id));
        },
        customSearch() {

            router.get(route('post.index', {
                category_id: this.category_id,
                type: this.type,
                posted: this.posted,
                search: this.search,
                from: this.from,
                to: this.to,
            }))
        },
        cleanSearch() {
            router.get(route("post.index"));
        },

    },
}
</script>