<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6 max-w-xl">
            <HeadingSmall title="Create Post" description="Form to create post" />
            <form class="my-6" @submit.prevent="submit">

                <Label>Title</Label>
                <div>
                    <Input id="title" v-model="form.title" type="text" class="block w-full mt-1" autofocus />
                    <InputError :message="errors.title" class="mt-2" />
                </div>

                <Label>Slug</Label>
                <div>
                    <Input id="slug" v-model="form.slug" type="text" class="block w-full mt-1" />
                    <InputError :message="errors.slug" class="mt-2" />
                </div>
                <Label>Date</Label>
                <div>
                    <Input id="date" v-model="form.date" type="date" class="block w-full mt-1" />
                    <InputError :message="errors.date" class="mt-2" />
                </div>

                <Label>Text</Label>
                <div>
                    <textarea id="text" v-model="form.text"
                        class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                    <InputError :message="errors.text" class="mt-2" />
                </div>

                <Label>Description</Label>
                <div>
                    <textarea id="description" v-model="form.description"
                        class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                    <InputError :message="errors.text" class="mt-2" />
                </div>

                <Label>Posted</Label>
                <div>
                    <select v-model="form.posted" class="rounded-md w-full border-gray-300 my-2">
                        <option value="not">No</option>
                        <option value="yes">Yes</option>
                    </select>
                    <InputError :message="errors.posted" class="mt-2" />
                </div>

                <Label>Type</Label>
                <div>
                    <select v-model="form.type" class="rounded-md w-full border-gray-300">
                        <option value="advert">Advert</option>
                        <option value="post">Post</option>
                        <option value="course">Course</option>
                        <option value="movie">Movie</option>
                    </select>

                    <InputError :message="errors.type" class="mt-2" />
                </div>

                <Label>Category</Label>
                <div>
                    <select v-model="form.category_id" class="rounded-md w-full border-gray-300">
                        <option v-for="c in categories" :value="c.id" :key="c.id">{{ c.title }}</option>
                    </select>

                    <InputError :message="errors.category_id" class="mt-2" />
                </div>

                <div>
                    <Button class="mt-2" :disabled="form.processing" type="submit">Send</Button>
                </div>

            </form>
        </div>

        <div v-if="post.id != ''">
            <div class="px-4 py-6 max-w-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="col-span-6">
                                <Label>Image</Label>
                                <Input type="file" @input="form.image = $event.target.files[0]" />
                                <InputError :message="errors.image" class="mt-2" />
                                <Button @click="upload">Upload</Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-6">
            <Label>Image Oruga</Label>

            <o-upload v-model="form.image">
                <o-button tag="upload-button" variant="primary">
                    <o-icon icon="upload"></o-icon>
                    <span>Click to Upload</span>
                </o-button>
            </o-upload>


            <InputError :message="errors.image" class="mt-2" />
        </div>
        <div class="col-span-6" v-if="post.id">
            <o-upload v-model="dropFiles" drag-drop>
                <section class="ex-center">
                    <p>
                        <o-icon icon="upload" size="is-large"> </o-icon>
                    </p>
                    <p>Drop your files here or click to upload</p>
                </section>
            </o-upload>
        </div>

        <div class="container mt-4" v-if="post.image">
    <div class="card">
        <div class="card-body">
            <img :src="'/image/post/'+post.image" :alt="post.title" class="max-w-sm rounded-md shadow-sm">
            <button variant="danger" size="small" class="mt-2" @click="form.delete(route('post.image.delete',post.id))">
                Delete
            </button>
            <a class="mt-2 ml-2 link-button-default" :href="'/image/post/'+post.image" download>Download</a>
        </div>
    </div>
</div>



    </AppLayout>
</template>

<script>

import { router, useForm } from '@inertiajs/vue3';

import { ref } from "vue";

import AppLayout from '@/layouts/AppLayout.vue';

import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import InputError from '@/components/InputError.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';

import { Button } from '@/components/ui/button';
export default {
    props: {
        errors: Object,
        post: {
            type: Object,
            default: {
                id: "",
                title: "",
                slug: "",
                date: "",
                description: "",
                text: "",
                type: "",
                posted: "",
                category_id: "",
                image: "",
            },
        },

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
        const dropFiles = ref("")

        const form = useForm({
            id: props.post.id,
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
                title: 'Edit Post: ' + props.post.title,
                // href: '/dashboard/post/create',
            },
        ];

        function submit() {
            if (props.post.id != '') {
                router.put(route("post.update", props.post.id), form)
            } else {
                router.post(route("post.store"), form)
            }
        }

        function upload() {
            router.post(route("post.upload", form.id), form);
        }

        return {
            submit, upload, form, breadcrumbs, dropFiles
        };
    }
}
</script>