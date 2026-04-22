<script setup lang="ts">
import { reactive, ref, watch } from 'vue'
import { useNotify } from '@admin/composable/useNotify'
import FormField from '@admin/components/form/FormField.vue'
import Input from '@admin/components/form/Input.vue'
import Textarea from '@admin/components/form/Textarea.vue'
import {ContactService} from '@admin/services/contact'
import CONFIG from '@admin/config/config'
import NotifyModal from '@admin/components/modals/NotifyModal.vue'
import { validateName,validateEmail, validatePhone } from '@admin/utils/validators'

interface Props {
  selected: {
    date: string | null
    time: string | null
    title?: string | null
    address?: string | null
  }
  selectedSlots?: { date: string | null; time: string | null }[]
  subjectId?: string,
  // hp_title?: string,
  // public_address_en?: string,
}

const props = defineProps<Props>()
const emit = defineEmits<{ (e: 'back'): void; (e: 'finish'): void }>()
const showThanks = ref(false)
const submitting = ref(false)
const notify = useNotify()

const formData = reactive({
    name: '',
    phone:'',
    email: '',
    subjectId: '',
    message: '',
    dates:[],
    hp_title: props.selected.title ?? '',
    public_address_en: props.selected.address ?? '',
    view_id: props.subjectId ?? '',
})

const errors = reactive({
    name: '',
    phone:'',
    email: '',
    subjectId: '',
    message: '',
})

function validate() {
    let valid = true
    formData.name = (formData.name || '').trim()
    formData.phone = (formData.phone || '').trim()
    formData.email = (formData.email || '').trim()

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

    const allDates = [
        ...(props.selectedSlots ?? []),
    ]

    if (props.selected?.date) {
        const exists = allDates.some(
            d => d.date === props.selected.date && d.time === props.selected.time
        )
        if (!exists) {
            allDates.unshift({
                date: props.selected.date,
                time: props.selected.time,
            })
        }
    }

    formData.dates = allDates.map(d => ({
        date: d.date ?? '',
        time: d.time ?? '',
    }))

    try {
        submitting.value = true
        const res = await ContactService.sendMail({ ...formData })
        showThanks.value = true
        // notify.success('Your tour request has been sent successfully!', { duration: 3000 })
    } catch (err) {
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
    } finally {
        submitting.value = false
    }
}

watch(showThanks, (v, oldV) => {
  if (oldV === true && v === false) {
    emit('finish')
  }
})

watch(() => props.subjectId, (v) => {
    formData.subjectId = v ?? ''
}, { immediate: true })
</script>

<template>
  <div class="modal__forms is-yourdetails" v-show="!showThanks">
    <header class="modal__header">
      <button type="button" class="modal__backlink" aria-label="Go Back" aria-controls="schedule" @click.prevent="emit('back')">
        <span class="is-label">Go Back</span>
      </button>
      <button type="button" class="modal__close" aria-label="Form Close" @click.prevent="emit('finish')"></button>
    </header>

    <div class="modal__block">
      <h2 class="title is-lsize is-red">In-person tour</h2>
      <p class="text is-lsize"><b>{{ props.selected.title || '' }}</b></p>
      <div class="modal__check">
        <p class="modal__check--schedule" v-if="props.selected.date">
          <b class="is-label">{{ props.selected.date }}<template v-if="props.selected.time"> at {{ props.selected.time }}</template></b>
        </p>
        <ul v-if="(props.selectedSlots?.length || 0) > 0" class="modal__check--list">
            <li
                v-for="(s, idx) in props.selectedSlots"
                :key="`slot-${idx}`"
                class="text"
                v-show="!(s.date === props.selected.date && s.time === props.selected.time)"
                :style="{ paddingBottom: idx === props.selectedSlots.length - 1 ? '0' : '16px' }"
                >
                <p class="modal__check--schedule" v-if="props.selected.date">
                    <b class="is-label">
                    {{ s.date }}
                    <template v-if="s.time"> at {{ s.time }}</template>
                    </b>
                </p>
            </li>
        </ul>
        <p v-if="props.selected.address" class="modal__check--address">
          <b class="is-label">{{ props.selected.address || '' }}</b>
        </p>
      </div>
    </div>

    <div class="modal__block">
      <h2 class="title is-lsize">Confirm your details</h2>
      <div class="modal__message">
        <p class="text">The property manager may use this information to confirm your tour.</p>
      </div>
    </div>

    <div class="modal__block">
      <form name="contactform" class="form" @submit.prevent="submitForm">
        <FormField id="name" label="First & last name" :required="true" :error="errors.name" style="padding-bottom: 16px;">
            <Input id="name" v-model="formData.name" placeholder="Your name"/>
        </FormField>

        <FormField id="phone" label="Phone" :required="true" :error="errors.phone" style="padding-bottom: 16px;">
            <Input id="phone" v-model="formData.phone" placeholder="(XXX)XXX-XXXX"/>
        </FormField>

        <FormField id="email" label="E-mail" :required="true" :error="errors.email" style="padding-bottom: 16px;">
            <Input id="email" v-model="formData.email" placeholder="E-mail address"/>
        </FormField>

        <FormField id="subjectId" label="Subject ID" :required="false" :error="errors.subjectId" style="padding-bottom: 16px;">
            <Input id="subjectId" v-model="formData.subjectId" placeholder="XXXXXXXXXX"/>
        </FormField>

        <FormField id="message" label="Message" :required="false" :error="errors.message">
            <textarea id="message" v-model="formData.message" class="form__textarea" placeholder=""></textarea>
        </FormField>

        <footer class="modal__footer">
        <button
          type="submit"
          class="btn is-type1"
          aria-label="Next"
          aria-controls="thanks"
          :disabled="submitting"
          :aria-busy="submitting ? 'true' : 'false'"
        >
          <span class="is-label" v-if="!submitting">Request tour</span>
          <span class="is-label" v-else>Sending...</span>
        </button>
        </footer>
      </form>
    </div>
  </div>

  <NotifyModal :modelValue="showThanks" @update:modelValue="val => showThanks = val" />
</template>
