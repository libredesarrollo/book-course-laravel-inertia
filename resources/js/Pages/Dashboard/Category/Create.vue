<template>
    <AppLayout title="Create Category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Category Create
                </template>

                <template #description>
                    Create a new category
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
        errors: Object
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
        })

        function submit() {
            router.post(route("category.store"), form)
        }

        return { form, submit }
    }
}
</script>