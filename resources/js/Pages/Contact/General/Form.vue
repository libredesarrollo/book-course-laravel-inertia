<template>
    <ContactLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6 max-w-xl">
            <HeadingSmall title="Create Contact" description="Form to create contact" />
            <form @submit.prevent="submit">
                <div class="col-span-6">
                    <Label>Subject</Label>
                    <Input id="subject" v-model="form.subject" type="text" class="block w-full mt-1" autofocus />
                    <InputError :message="errors.subject" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <Label>Message</Label>
                    <textarea v-model="form.message" class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                    <InputError :message="errors.message" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <Label>Type</Label>
                    <select v-model="form.type" class="block w-full mt-1 border-gray-300 rounded-md">
                        <option value="company">Company</option>
                        <option value="person">Person</option>
                    </select>

                    <InputError :message="errors.type" class="mt-2" />
                </div>

                <Button class="mt-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </Button>

            </form>
        </div>
    </ContactLayout>
</template>

<script lang="ts">

import { router, useForm } from "@inertiajs/vue3"

import ContactLayout from "@/Layouts/ContactLayout.vue";

import { type BreadcrumbItem } from '@/types';

import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import HeadingSmall from '@/components/HeadingSmall.vue';

export default {
    props: {
        errors: Object,
        contactGeneral: {
            default: {
                id: '',
                subject: '',
                type: '',
                message: ''
            }
        }
    },
    components: {
        ContactLayout,
        InputError,
        Label,
        Button,
        Input,
        HeadingSmall
    },
    setup(props) {

        const breadcrumbs: BreadcrumbItem[] = [
            {
                title: 'Contact',
                href: '',
                // href: '/dashboard/category/create',
            },
        ];

        const form = useForm({
            id: props.contactGeneral.id,
            subject: props.contactGeneral.subject,
            type: props.contactGeneral.type,
            message: props.contactGeneral.message,
        })

        function submit() {
            if (form.id == '') {
                router.post(route("contact-general.store"), form)
            } else {
                router.put(route("contact-general.update", form.id), form)
            }

        }

        return { form, submit, breadcrumbs }
    }
}
</script>