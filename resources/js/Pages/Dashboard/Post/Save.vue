<template>
    <AppLayout title="Create Post">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Post
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Post

                    <span v-if="post.id != ''">
                        Edit
                    </span>
                    <span v-else>
                        Create
                    </span>
                </template>

                <template #description>
                    <span v-if="post.id != ''">
                        Edit a post <strong>{{ post.title }}</strong>
                    </span>
                    <span v-else>
                        Create a post
                    </span>

                </template>

                <template #form>
                    <div class="col-span-6">
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" v-model="form.title" type="text" class="block w-full mt-1" autofocus />
                        <InputError :message="errors.title" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="slug" value="Slug" />
                        <TextInput id="slug" v-model="form.slug" type="text" class="block w-full mt-1" autofocus />
                        <InputError :message="errors.slug" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="date" value="Date" />
                        <TextInput id="date" v-model="form.date" type="date" class="block w-full mt-1" />
                        <InputError :message="errors.date" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="text" value="Text" />
                        <textarea id="text" v-model="form.text"
                            class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                        <InputError :message="errors.text" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="description" value="Description" />
                        <textarea id="description" v-model="form.description"
                            class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                        <InputError :message="errors.text" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="text" value="Posted" />
                        <select v-model="form.posted" class="rounded-md w-full border-gray-300">
                            <option value="not">No</option>
                            <option value="yes">Yes</option>
                        </select>

                        <InputError :message="errors.posted" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="type" value="Type" />
                        <select v-model="form.type" class="rounded-md w-full border-gray-300">
                            <option value="Advert">Advert</option>
                            <option value="post">Post</option>
                            <option value="course">Course</option>
                            <option value="movie">Movie</option>
                        </select>

                        <InputError :message="errors.type" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="category_id" value="Category" />
                        <select v-model="form.category_id" class="rounded-md w-full border-gray-300">
                            <option v-for="c in categories" :value="c.id" :key="c.id">{{ c.title }}</option>
                        </select>

                        <InputError :message="errors.category_id" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Image" />
                        <TextInput type="file" @input="form.image = $event.target.files[0]" />
                        <InputError :message="errors.image" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Image Oruga" />

                        <o-upload v-model="form.image">
                            <o-button tag="upload-button" variant="primary">
                                <o-icon icon="upload"></o-icon>
                                <span>Click to Upload</span>
                            </o-button>
                        </o-upload>

                        <InputError :message="errors.image" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <!-- <o-upload v-model="dropFiles" v-if="post.id" multiple drag-drop> -->
                        <o-upload v-model="dropFiles" v-if="post.id"  drag-drop>
                            <section class="">
                                <o-icon icon="upload"></o-icon>
                                <span>Drop your files here or click to upload</span>
                            </section>
                        </o-upload>
                        
                        <div class="container mt-4" v-if="post.image">
                            <div class="card">
                                <div class="card-body">
                                    <img :src="'/image/post/'+post.image" :alt="post.title" class="max-w-sm rounded-md shadow-sm">
                                    <danger-button class="mt-2" @click="form.delete(route('post.image.delete',post.id))">
                                        Delete
                                    </danger-button>
                                    <a class="mt-2 ml-2 link-button-default" :href="'/image/post/'+post.image" download>Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <span v-if="post.id != ''">
                            Edit
                        </span>
                        <span v-else>
                            Create
                        </span>
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>

        <div v-if="post.id != ''">
            <!-- <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="col-span-6">
                                
                                <InputLabel value="Image" />
                                
                                <TextInput type="file" @input="form.image = $event.target.files[0]" />
                                
                                <InputError :message="errors.image" class="mt-2" />

                                <PrimaryButton @click="upload">Upload</PrimaryButton>
                                
                            </div>
                            </div>
                        </div>
                    </div>
                </div> -->
        </div>

    </AppLayout>
</template>

<script>

import { watch, ref } from 'vue'

import { router, useForm } from "@inertiajs/vue3"

import AppLayout from "@/Layouts/AppLayout.vue";

import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from '@/Components/TextInput.vue';

export default {
    props: {
        errors: Object,
        post: {
            type: Object,
            default: {
                id: '',
                title: '',
                slug: '',
                date: '',
                destription: '',
                text: '',
                posted: '',
                type: '',
                category_id: '',
                image: '',
            }
        },
        categories: Array
    },
    components: {
        AppLayout,
        FormSection,
        InputError,
        InputLabel,
        PrimaryButton,
        DangerButton,
        TextInput
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
            image: props.post.image,
        })

        // const dropFiles = ref([])
        const dropFiles = ref('')

        function submit() {
            if (props.post.id != '') {
                // router.put(route("post.update", props.post.id), form)
                router.post(route("post.update", props.post.id), {
                    _method: 'put',
                    ...form
                })
            } else {
                router.post(route("post.store"), form)
            }
        }

        function upload() {
            router.post(route("post.upload", props.post.id), form)
        }

        // watch(() => dropFiles, (currentValue, oldValue) => {
        //     console.log(dropFiles)
        // }, { deep: true })

        watch(() => dropFiles, (currentValue, oldValue) => {
            // console.log(dropFiles.value)
            router.post(route("post.upload", props.post.id), {
                // "image": currentValue.value[currentValue.value.length - 1]
                "image": currentValue.value
            });
        },
            { deep: true });


        return { form, submit, upload, dropFiles }
    },

}
</script>