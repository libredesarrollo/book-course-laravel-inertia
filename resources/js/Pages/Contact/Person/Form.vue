<template>
    <ContactLayout>
        <div class="px-4 py-6 max-w-xl">
            <HeadingSmall title="Create Contact" description="Form to create contact" />
            <form @submit.prevent="submit">
                <div class="col-span-6">
                    <Label>Name</Label>
                    <Input id="name" v-model="form.name" type="text" class="block w-full mt-1" autofocus />
                    <InputError :message="errors.name" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <Label>Surname</Label>
                    <Input id="surname" v-model="form.surname" type="text" class="block w-full mt-1" autofocus />
                    <InputError :message="errors.surname" class="mt-2" />
                </div>

                <div class="col-span-6">
                    <Label>Other</Label>
                    <textarea v-model="form.other" class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                    <InputError :other="errors.other" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <Label>Choices</Label>

                    <select v-model="form.choices" class="block w-full mt-1 border-gray-300 rounded-md">
                        <option value="advert">Advert</option>
                        <option value="post">Post</option>
                        <option value="course">Course</option>
                        <option value="movie">Movie</option>
                        <option value="other">Other</option>
                    </select>

                    <InputError :message="errors.type" class="mt-2" />
                </div>
                <Button class="mt-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </Button>
                <span class="mt-1 ml-3 cursor-pointer" @click="$emit('backStepEvent', 1)">Back</span>
            </form>
        </div>
    </ContactLayout>
</template>

<script>

import { router, useForm } from "@inertiajs/vue3"

import ContactLayout from "@/Layouts/ContactLayout.vue";

import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import HeadingSmall from '@/components/HeadingSmall.vue';

export default {
    emits: ['backStepEvent'],
    props: {
        errors: Object,
        contactGeneralId: {
            type: Number,
        },
        contactPerson: {
            default(props) {
                return {
                    id: '',
                    name: '',
                    surname: '',
                    choices: '',
                    other: '',
                    contact_general_id: props.contactGeneralId
                }
            },
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
        const form = useForm({
            id: props.contactPerson.id,
            name: props.contactPerson.name,
            surname: props.contactPerson.surname,
            choices: props.contactPerson.choices,
            other: props.contactPerson.other,
            // contact_general_id: props.contactPerson.contact_general_id,
            contact_general_id: props.contactGeneralId,
        })

        function submit() {
            if (form.id == '') {
                router.post(route("contact-person.store"), form)
            } else {
                router.put(route("contact-person.update", form.id), form)
            }
        }

        return { form, submit }
    }
}
</script>