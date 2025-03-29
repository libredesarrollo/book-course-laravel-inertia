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
                    <Label>Identification</Label>
                    <Input id="identification" v-model="form.identification" type="text" class="block w-full mt-1"
                        autofocus />
                    <InputError :message="errors.identification" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <Label>Email</Label>
                    <Input id="email" v-model="form.email" type="email" class="block w-full mt-1" autofocus />
                    <InputError :message="errors.email" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <Label>Extra</Label>
                    <textarea v-model="form.extra" Input></textarea>
                    <InputError :extra="errors.extra" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <Label>Choices</Label>
                    <select v-model="form.choices" Input>
                        <option value="Advert">Advert</option>
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
            default: {
                value: 0
            }
        },
        contactCompany: {
            default(props) {
                return {
                    id: '',
                    name: '',
                    identification: '',
                    email: '',
                    choices: '',
                    extra: '',
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
            id: props.contactCompany.id,
            name: props.contactCompany.name,
            identification: props.contactCompany.identification,
            email: props.contactCompany.email,
            choices: props.contactCompany.choices,
            extra: props.contactCompany.extra,
            contact_general_id: props.contactCompany.contact_general_id,
        })

        function submit() {
            if (form.id == '') {
                router.post(route("contact-company.store"), form)
            } else {
                router.put(route("contact-company.update", form.id), form)
            }

        }

        return { form, submit }
    }
}
</script>