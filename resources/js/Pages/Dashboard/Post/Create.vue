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
                    Post Create
                </template>

                <template #description>
                    Create a new post
                </template>

                <template #form>
                    <div class="col-span-6">
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" v-model="form.title" type="text" class="block w-full mt-1" autofocus />
                        <InputError :message="errors.title" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="slug" value="Slug" />
                        <TextInput id="slug" v-model="form.slug" type="text" class="block w-full mt-1" />
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
                </template>

                <template #actions>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Create
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>

<script>

import { router, useForm } from "@inertiajs/vue3"

import AppLayout from "@/Layouts/AppLayout.vue";

import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

export default {
    props: {
        errors: Object,
        categories: Array
    },
    components: {
        AppLayout,
        FormSection,
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput
    },
    setup() {
        const form = useForm({
            title: '',
            slug: '',
            date: '',
            destription: '',
            text: '',
            posted: '',
            type: '',
            category_id: '',
        })

        function submit() {
            router.post(route("post.store"), form)
        }

        return { form, submit }
    }
}
</script>