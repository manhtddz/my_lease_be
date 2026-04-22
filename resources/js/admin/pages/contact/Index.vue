<template>
    <h1 class="title is-pagetitle">Contact</h1>

    <form name="contactform" class="form" @submit.prevent="submitForm">
        <div class="main__container">

            <FormField id="name" label="First & last name" :required="true" :error="errors.name">
                <Input id="name" v-model="formData.name" placeholder="Your name"/>
            </FormField>

            <FormField id="phone" label="Phone" :required="true" :error="errors.phone">
                <Input id="phone" v-model="formData.phone" placeholder="(XXX)XXX-XXXX"/>
            </FormField>

            <FormField id="email" label="E-mail" :required="true" :error="errors.email">
                <Input id="email" v-model="formData.email" placeholder="E-mail address"/>
            </FormField>

            <FormField id="subjectId" label="Subject ID" :required="false" :error="errors.subjectId">
                <Input id="subjectId" v-model="formData.subjectId" placeholder="XXXXXXXXXX"/>
            </FormField>

            <FormField id="details" label="Request Details" :required="false" :error="errors.requestDetails">
                <textarea id="details" v-model="formData.requestDetails" class="form__textarea" placeholder=""></textarea>
            </FormField>

            <FormField id="questions" label="Other Questions" :required="false" :error="errors.otherQuestions">
                <textarea id="questions" v-model="formData.otherQuestions" class="form__textarea" placeholder=""></textarea>
            </FormField>

            <div class="form__footer">
                <button type="submit" class="btn is-type1 icon-send">
                    <span class="is-label">Submit Your Inquiry</span>
                </button>
            </div>
        </div>
    </form>

    <NotifyModal v-model="showThanks" />

</template>
<script setup lang="ts">
import { useNotify } from '@admin/composable/useNotify'
import NotifyModal from '@admin/components/modals/NotifyModal.vue'
import { ref, reactive} from 'vue'
import FormField from "@admin/components/form/FormField.vue"
import Input from "@admin/components/form/Input.vue"
import {ContactService} from "@admin/services/contact"
import { validateEmail, validatePhone, validateName } from '@admin/utils/validators'

const notify = useNotify()
const showThanks = ref(false)
const formData = reactive<{ [key: string]: string }>({
    name: '',
    phone:'',
    email: '',
    subjectId: '',
    requestDetails: '',
    otherQuestions: '',
})

const errors = reactive<{ [key: string]: string }>({
    name: '',
    phone:'',
    email: '',
    subjectId: '',
    requestDetails: '',
    otherQuestions: '',
})

function validate() {
    let valid = true

    const nameRes = validateName(formData.name)
    errors.name = nameRes.message
    if (!nameRes.valid) valid = false

    const phoneRes = validatePhone(formData.phone)
    errors.phone = phoneRes.message
    if (!phoneRes.valid) valid = false

    const emailRes = validateEmail(formData.email)
    errors.email = emailRes.message
    if (!emailRes.valid) valid = false

    return valid
}

async function submitForm() {
    if (!validate()) return
    try {
        await ContactService.sendMail({ ...formData })
        showThanks.value = true
        Object.keys(formData).forEach(key => formData[key] = '');
        Object.keys(errors).forEach(key => errors[key] = '');
    } catch (err :any) {
        if (err.response?.status === 422 && err.response.data.errors) {

            for (const key in errors) {
                errors[key] = ''
            }

            const backendErrors = err.response.data.errors
            for (const key in backendErrors) {
                if (errors.hasOwnProperty(key)) {
                    errors[key] = backendErrors[key][0]
                }
            }
        }
    }
}
</script>

