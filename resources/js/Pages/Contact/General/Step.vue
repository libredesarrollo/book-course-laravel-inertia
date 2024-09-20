<template>
    <div>
        <ContactLayout>

            <div class="flex" v-if="$page.props.step != 4">
                <div class="flex mx-auto flex-col sm:flex-row">
                    <div class="step" :class="{ active: $page.props.step == 1 }">
                        STEP 1
                    </div>
                    <div class="step" :class="{ active: parseInt($page.props.step) == 2 }">
                        STEP 2 
                    </div>
                    <div class="step" :class="{ active: $page.props.step == 3 }">
                        STEP 3
                    </div>
                </div>
            </div>

            <ContactGeneral v-if="$page.props.step == 1" :errors="errors" :contactGeneral="contactGeneral" />
            <div v-if="contactGeneral">
                <ContactCompany :contactGeneralId="contactGeneral.id" @back-step-event="backStep"
                    v-if="$page.props.step == 2" :errors="errors" :contactCompany="contactGeneral.company" />
                <ContactPerson :contactGeneralId="contactGeneral.id" @back-step-event="backStep"
                    v-if="$page.props.step == 2.5" :errors="errors" :contactPerson="contactGeneral.person" />
                <ContactDetail :contactGeneralId="contactGeneral.id" @back-step-event="backStep"
                    v-if="$page.props.step == 3" :errors="errors" :contactDetail="contactGeneral.detail" />
                <div v-if="$page.props.step == 4">END</div>

            </div>
        </ContactLayout>
    </div>
</template>
<script>
import ContactLayout from "@/Layouts/ContactLayout.vue";

import ContactGeneral from "@/Pages/Contact/General/Form.vue"
import ContactCompany from "@/Pages/Contact/Company/Form.vue"
import ContactPerson from "@/Pages/Contact/Person/Form.vue"
import ContactDetail from "@/Pages/Contact/Detail/Form.vue"

export default {
    components: {
        ContactLayout,
        ContactGeneral,
        ContactCompany,
        ContactPerson,
        ContactDetail
    },
    props: {
        errors: Object,
        contactGeneral: Object
    },
    methods: {
        backStep(value) {
            console.log(value)
            if (value == 2 && this.contactGeneral && this.contactGeneral.type) {
                // paso 2
                if (this.contactGeneral.type == 'person') {
                    this.$page.props.step = 2.5
                } else {
                    this.$page.props.step = 2
                }
            } else {
                // paso 1
                this.$page.props.step = value
            }
        }
    },
}
</script>