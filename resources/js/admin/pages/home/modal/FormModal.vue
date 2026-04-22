<script setup lang="ts">
import { computed, ref, watch, reactive, onMounted } from 'vue'
import { useNotify } from '@admin/composable/useNotify'
import DetailTourModal from './DetailTourModal.vue'
import FormHeader from '@admin/pages/home/modal/components/FormHeader.vue'
import ScheduleSection from '@admin/pages/home/modal/components/ScheduleSection.vue'
import FormFooter from '@admin/pages/home/modal/components/FormFooter.vue'

interface Props {
  id: string
  holidays: string[]
  show: boolean
  property?: {
    hp_title?: string
    view_id?: string | null
    property?: { public_address_en?: string }
  }
}

const props = defineProps<Props>()
const emit = defineEmits<{(e: 'update:show', value: boolean): void}>()
const dates = computed(() => makeDates(props.holidays))
const isShow = ref(!!props.show)
const times = ['All day OK','10:00-12:00','13:00-15:00','15:00-17:00']
const selected = reactive<{ date: string | null; time: string | null; address: string | null; title: string | null }>({
  date: null,
  time: null,
  address: null,
  title: null,
})
// Track order user completed sections (by index)
const selectionOrder = reactive<number[]>([])

const selectedSlots = computed(() => {
  // Live computed version (not used for display after Next). Kept for reference.
  const uniq = new Set<string>()
  const indices = [0, 1, 2]
  const primary = indices.find(i => sectionDates[i] && sectionTimes[i])
  const out: { date: string | null; time: string | null }[] = []
  for (const i of indices) {
    if (primary === i) continue
    const d = sectionDates[i]
    const t = sectionTimes[i]
    if (!d || !t) continue
    const key = `${d}__${t}`
    if (uniq.has(key)) continue
    uniq.add(key)
    out.push({ date: formatDate(d as string), time: t })
    if (out.length >= 3) break
  }
  return out
})
const selectedSlotsSnapshot = ref<{ date: string | null; time: string | null }[]>([])
const showDetail = ref(false)
const numberOfSections = 3
const notify = useNotify()
const lastEditedIndex = ref<number | null>(null)
const lastCompletedIndex = ref<number | null>(null)

function makeDates(holidays: string[]) {
  const res: { iso:string; week:string; day:string; month:string }[] = []
  const now = new Date()
  const end = new Date()
  end.setDate(now.getDate() + 14)
  const normalize = (s: string) => {
    const raw = String(s ?? '')
    const m = raw.match(/\d{4}[-\/.]\d{2}[-\/.]\d{2}/)
    const ymd = (m ? m[0] : raw.slice(0,10)).replace(/[\/.]/g, '-')
    return ymd
  }
  const holidaySet = new Set(holidays.map(normalize))

  const isoLocal = (d: Date) => {
    const y = d.getFullYear()
    const m = String(d.getMonth() + 1).padStart(2, '0')
    const day = String(d.getDate()).padStart(2, '0')
    return `${y}-${m}-${day}`
  }

  for (let d = new Date(now); d <= end; d.setDate(d.getDate() + 1)) {
    const iso = isoLocal(d)
    if (holidaySet.has(iso)) continue
    res.push({
      iso,
      week: d.toLocaleDateString('en-US',{weekday:'short'}),
      day:  d.getDate().toString(),
      month:d.toLocaleDateString('en-US',{month:'short'}),
    })
  }
  return res
}


function labelForDate(iso: string | null) {
  if (!iso) return ''
  const d = dates.value.find(x => x.iso === iso)
  return d ? `${d.week} ${d.day} ${d.month}` : iso
}

function formatDate(dateStr: string) {
  // Parse ISO (YYYY-MM-DD) as LOCAL date to avoid UTC timezone shift
  // that can cause the weekday to be off by one.
  const [y, m, d] = dateStr.split('-').map(Number)
  const local = new Date(y, (m || 1) - 1, d || 1)
  return local
    .toLocaleDateString('en-US', {
      weekday: 'short',
      month: 'short',
      day: '2-digit',
    })
    .replace(/(\w{3}) (\w{3}) (\d{2})/, '$1, $2 $3')
}

function nextStep() {
  // Require at least one complete selection (date + time)
  const firstComplete = sectionDates.findIndex((d, i) => !!d && !!sectionTimes[i])
  if (firstComplete === -1) {
    notify.warn('Please select at least one date and time', { duration: 3000 })
    return
  }

  // Primary = the FIRST completed by user's selection order; fallback to first complete (top-down)
  const firstFromOrder = selectionOrder.length ? selectionOrder[0] : null
  const idx = (firstFromOrder != null && sectionDates[firstFromOrder] && sectionTimes[firstFromOrder])
    ? (firstFromOrder as number)
    : firstComplete

  selected.date = formatDate(sectionDates[idx] as string)
  selected.time = sectionTimes[idx]

  // Build snapshot for display: order of selection from first to last, excluding primary
  const uniq = new Set<string>()
  const out: { date: string | null; time: string | null }[] = []
  for (let k = 0; k < selectionOrder.length; k++) {
    const i = selectionOrder[k]
    if (i === idx) continue
    const d = sectionDates[i]
    const t = sectionTimes[i]
    if (!d || !t) continue
    const key = `${d}__${t}`
    if (uniq.has(key)) continue
    uniq.add(key)
    out.push({ date: formatDate(d as string), time: t })
    if (out.length >= 3) break
  }
  selectedSlotsSnapshot.value = out
  showDetail.value = true
}

function closeOnBackdrop() {
  showDetail.value = false
  emit('update:show', false)
}

function onOverlayClick(event: MouseEvent) {
  // Do not allow overlay click to close when the detail modal is open
  if (showDetail.value) return
  const current = event.currentTarget as HTMLElement | null
  if (!current) return
  const target = event.target as HTMLElement
  const container = current.querySelector('.modal__container') as HTMLElement | null
  if (container && !container.contains(event.target as Node)) {
    closeOnBackdrop()
  }
}

watch(() => props.show, (v) => {
  isShow.value = !!v
  if (v) {
    showDetail.value = false
    for (let i = 0; i < sectionsOpen.length; i++) sectionsOpen[i] = false
    sectionsOpen[0] = true
    selected.title = props.property?.hp_title ?? null
    selected.address = props.property?.property?.public_address_en ?? null
    for (let i = 0; i < numberOfSections; i++) { sectionDates[i] = null; sectionTimes[i] = null }
    lastEditedIndex.value = null
    lastCompletedIndex.value = null
    selectionOrder.splice(0, selectionOrder.length)
  } else {
    showDetail.value = false
    selected.date = null
    selected.time = null
  }
})

watch(() => showDetail.value, (v) => {
})

const sectionsOpen = reactive(Array(numberOfSections).fill(false))
const sectionDates = reactive<(string | null)[]>(Array(numberOfSections).fill(null))
const sectionTimes = reactive<(string | null)[]>(Array(numberOfSections).fill(null))

// Maintain selection order when a section becomes (in)complete
function updateCompletion(index: number) {
  const complete = !!sectionDates[index] && !!sectionTimes[index]
  const pos = selectionOrder.indexOf(index)
  if (complete) {
    if (pos === -1) selectionOrder.push(index)
  } else {
    if (pos !== -1) selectionOrder.splice(pos, 1)
  }
}

onMounted(() => {sectionsOpen[0] = true})

function openSection(index: number) {
  sectionsOpen[index] = true
}

function onFinish() {
  showDetail.value = false
  emit('update:show', false)
  selected.date = null
  selected.time = null
}
function onBack() {
  showDetail.value = false
}

function onHeaderClose() {
  // If in detail step, go back; otherwise close the modal entirely
  if (showDetail.value) {
    onBack()
  } else {
    closeOnBackdrop()
  }
}
</script>

  <template>
    <div :id="props.id" :class="['modal','form', { 'is-open': isShow }]" :aria-hidden="!isShow">
      <div class="modal__overlay" tabindex="-1" :data-modalclose="props.id" @click.capture="onOverlayClick">
        <form class="form">
          <section class="modal__container" role="dialog" aria-modal="true">
            <div class="modal__forms is-schedule" v-if="!showDetail">
            <FormHeader @close="onHeaderClose" />
              <div class="modal__block">
                  <h2 class="title is-lsize">Request a tour</h2>
                  <div class="modal__message">
                      <p class="text">Tip: Selecting multiple times helps schedule your tour faster</p>
                  </div>
            </div>

           <template v-for="n in numberOfSections" :key="n">
              <ScheduleSection
                :index="n"
                :dates="dates"
                :times="times"
                :modelValueOpen="sectionsOpen[n-1]"
                :modelValueDate="sectionDates[n-1]"
                :modelValueTime="sectionTimes[n-1]"
                @update:modelValueOpen="val => { sectionsOpen[n-1] = val }"
                @update:modelValueDate="val => { sectionDates[n-1] = val; lastEditedIndex = n-1; if (sectionDates[n-1] && sectionTimes[n-1]) { lastCompletedIndex = n-1 }; updateCompletion(n-1) }"
                @update:modelValueTime="val => { sectionTimes[n-1] = val; lastEditedIndex = n-1; if (sectionDates[n-1] && sectionTimes[n-1]) { lastCompletedIndex = n-1 }; updateCompletion(n-1) }"
              />
            </template>

            <FormFooter @next="nextStep" />
          </div>
          <!-- MARK:Your Details -->
          <DetailTourModal
            v-else
            :selected="selected"
            :selected-slots="selectedSlotsSnapshot"
            :subject-id="props.property?.view_id ?? ''"
            @back="onBack"
            @finish="onFinish"
          />
        </section>
      </form>
    </div>
  </div>
</template>
