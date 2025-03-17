<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6 max-w-xl">
            <HeadingSmall title="Create Category" description="Form to create categories" />
            <form class="my-6" @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-2">
                    <Label>Title</Label>
                    <!-- <input type="text" v-model="form.title"> -->
                    <Input type="text" v-model="form.title" placeholder="Title" required />
                    <!-- <div v-if="errors.title">{{  errors.title }}</div> -->
                    <InputError :message="errors.title" />

                    <Label>Slug</Label>
                    <!-- <input type="text" v-model="form.slug"> -->
                    <Input type="text" v-model="form.slug" placeholder="Slug" required />
                    <!-- <div v-if="errors.slug">{{  errors.slug }}</div> -->
                    <InputError :message="errors.slug" />

                    <div>
                        <Button :disabled="form.processing" type="submit">Send</Button>
                    </div>
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
        category: Object
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
            title: props.category.title,
            slug: props.category.slug,
        });
  
        const breadcrumbs = [
            {
                title: 'Edit Category: ' + props.category.title,
                // href: '/dashboard/category/create',
            },
        ];

        function submit() {
            router.put(route("category.update", props.category.id), form);
        }

        return {
            submit, form, breadcrumbs
        };
    }
}
</script>