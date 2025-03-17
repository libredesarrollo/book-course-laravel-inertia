<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6 max-w-xl">
            <HeadingSmall title="Create Post" description="Form to create post" />
            <form class="my-6" @submit.prevent="submit">

                <Label>Title</Label>
                <Input id="title" v-model="form.title" type="text" class="block w-full mt-1" autofocus />
                <InputError :message="errors.title" class="mt-2" />

                <Label>Slug</Label>
                <Input id="slug" v-model="form.slug" type="text" class="block w-full mt-1" />
                <InputError :message="errors.slug" class="mt-2" />

                <Label>Date</Label>
                <Input id="date" v-model="form.date" type="date" class="block w-full mt-1" />
                <InputError :message="errors.date" class="mt-2" />

                <Label>Text</Label>
                <textarea id="text" v-model="form.text" class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                <InputError :message="errors.text" class="mt-2" />

                <Label>Description</Label>
                <textarea id="description" v-model="form.description"
                    class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                <InputError :message="errors.text" class="mt-2" />

                <Label>Posted</Label>
                <select v-model="form.posted" class="rounded-md w-full border-gray-300 my-2">
                    <option value="not">No</option>
                    <option value="yes">Yes</option>
                </select>
                <InputError :message="errors.posted" class="mt-2" />

                <Label>Type</Label>
                <select v-model="form.type" class="rounded-md w-full border-gray-300">
                    <option value="advert">Advert</option>
                    <option value="post">Post</option>
                    <option value="course">Course</option>
                    <option value="movie">Movie</option>
                </select>

                <InputError :message="errors.type" class="mt-2" />

                <Label>Category</Label>
                <select v-model="form.category_id" class="rounded-md w-full border-gray-300">
                    <option v-for="c in categories" :value="c.id" :key="c.id">{{ c.title }}</option>
                </select>

                <InputError :message="errors.category_id" class="mt-2" />

                <div>
                    <Button class="mt-2" :disabled="form.processing" type="submit">Send</Button>
                </div>

            </form>
        </div>
    </AppLayout>
</template>

<script>

import { router, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';

import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import InputError from '@/components/InputError.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';

import { Button } from '@/components/ui/button';
export default {
    props: {
        errors: Object,
        post: Object,
        category: Object,
        categories: Array
    },
    components: {
        AppLayout,
        InputError,
        HeadingSmall,
        Input,
        Label,
        Button,
    },
    setup(props) {
        const form = useForm({
            title: props.post.title,
            slug: props.post.slug,
            date: props.post.date,
            description: props.post.description,
            text: props.post.text,
            posted: props.post.posted,
            type: props.post.type,
            category_id: props.post.category_id,
        })

        const breadcrumbs = [
            {
                title: 'Edit Category: ' + props.post.title,
                // href: '/dashboard/post/create',
            },
        ];

        function submit() {
            router.put(route("post.update", props.post.id), form)
        }

        return {
            submit, form, breadcrumbs
        };
    }
}
</script>