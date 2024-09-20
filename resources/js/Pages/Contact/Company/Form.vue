<template>
    <ContactLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Contact
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Create Contact company
                </template>

                <template #description>
                    Create Contact
                </template>

                <template #form>
                    <div class="col-span-6">
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" v-model="form.name" type="text" class="block w-full mt-1" autofocus />
                        <InputError :message="errors.name" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="identification" value="Identification" />
                        <TextInput id="identification" v-model="form.identification" type="text"
                            class="block w-full mt-1" autofocus />
                        <InputError :message="errors.identification" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" v-model="form.email" type="email" class="block w-full mt-1" autofocus />
                        <InputError :message="errors.email" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="extra" value="Extra" />
                        <textarea v-model="form.extra" class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                        <InputError :extra="errors.extra" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="choices" value="Choices" />

                        <select v-model="form.choices" class="block w-full mt-1 border-gray-300 rounded-md">
                            <option value="Advert">Advert</option>
                            <option value="post">Post</option>
                            <option value="course">Course</option>
                            <option value="movie">Movie</option>
                            <option value="other">Other</option>
                        </select>

                        <InputError :message="errors.type" class="mt-2" />
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                    <span class="mt-1 ml-3 cursor-pointer" @click="$emit('backStepEvent', 1)">Back</span>
                </template>
            </FormSection>
        </div>

    </ContactLayout>
</template>

<script>

import { router, useForm } from "@inertiajs/vue3"

import ContactLayout from "@/Layouts/ContactLayout.vue";

import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

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
        FormSection,
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput
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