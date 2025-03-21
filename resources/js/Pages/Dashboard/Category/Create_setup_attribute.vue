<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6 max-w-xl">
            <HeadingSmall title="Create Category" description="Form to create categories" />
            <form class="my-6" @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-2">
                    <Label>Title</Label>
                    <!-- <input type="text" v-model="form.title"> -->
                    <div>
                        <Input type="text" v-model="form.title" placeholder="Title" required />
                        <!-- <div v-if="errors.title">{{  errors.title }}</div> -->
                        <InputError :message="errors.title" />
                    </div>

                    <Label>Slug</Label>
                    <!-- <input type="text" v-model="form.slug"> -->
                    <div>
                        <Input type="text" v-model="form.slug" placeholder="Slug" />
                        <!-- <div v-if="errors.slug">{{  errors.slug }}</div> -->
                        <InputError :message="errors.slug" />
                    </div>

                    <div>
                        <Button :disabled="form.processing" type="submit">Send</Button>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>

import { router, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';

import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import InputError from '@/components/InputError.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';

import { Button } from '@/components/ui/button';

const form = useForm({
    title: '',
    slug: '',
});

const props = defineProps({
    errors: Object,
});

const breadcrumbs = [
    {
        title: 'Categories',
        // href: '/dashboard/category/create',
    },
];

function submit() {
    console.log(form);
    // form.post(route('category.store',form))
    router.post(route('category.store', form))
    // Your submit logic here
}


</script>