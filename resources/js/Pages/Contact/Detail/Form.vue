<template>
    <ContactLayout>
        <div class="px-4 py-6 max-w-xl">
            <HeadingSmall title="Create Contact" description="Form to create contact" />
            <form @submit.prevent="submit">
                <div class="col-span-6">
                    <Label>Extra</Label>
                    <textarea v-model="form.extra" class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                    <InputError :message="errors.extra" class="mt-2" />
                </div>
                <Button class="mt-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </Button>
                <span class="mt-1 ml-3 cursor-pointer" @click="$emit('backStepEvent', 2)">Back</span>
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
            type: Number
        },
        contactDetail: {
            default(props) {
                return {
                    id: '',
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
            id: props.contactDetail.id,
            extra: props.contactDetail.extra,
            contact_general_id: props.contactGeneralId,
        })

        function submit() {
            if (form.id == '') {
                router.post(route("contact-detail.store"), form)
            } else {
                router.put(route("contact-detail.update", form.id), form)
            }
        }

        return { form, submit }
    }
}
</script>