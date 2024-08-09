<template>
    <AppLayout title="Create Category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category
            </h2>
        </template>

        <form @submit.prevent="submit">
            <label for="">Title</label>
            <input type="text" v-model="form.title">
            <div v-if="errors.title">{{ errors.title }}</div>
            <label for="">Slug</label>
            <input type="text" v-model="form.slug">
            <div v-if="errors.slug">{{ errors.slug }}</div>
            <input type="submit" value="Send">
        </form>
    </AppLayout>
</template>
<script>

import { router, useForm } from "@inertiajs/vue3"

import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    props: {
        errors: Object
    },
    components: {
        AppLayout
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