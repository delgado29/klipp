<template>
  <div class="p-4">
    <h2 class="mb-3">Agendar cita en:</h2>
    <div v-if="business" class="mb-4">
      <h4>{{ business.name }}</h4>
      <p>{{ business.description }}</p>
      <p><strong>Teléfono:</strong> {{ business.phone }}</p>
    </div>
    <div v-else>
      <p>Cargando negocio...</p>
    </div>

    <div v-if="services.length">
      <h5 class="mb-3">Servicios disponibles</h5>
      <b-list-group>
        <b-list-group-item
          v-for="service in services"
          :key="service.id"
          class="d-flex justify-content-between align-items-center"
        >
          <div>
            <h6 class="mb-1">{{ service.name }}</h6>
            <p class="mb-1">{{ service.description }}</p>
            <small><strong>Precio:</strong> ${{ service.price }} | <strong>Duración:</strong> {{ service.duration }} min</small>
          </div>
          <b-button size="sm" variant="primary" @click="selectService(service)">Agendar</b-button>
        </b-list-group-item>
      </b-list-group>
    </div>

    <b-card class="mb-4" v-if="selectedService">
      <h5>Formulario de cita</h5>
      <b-form @submit.prevent="submitAppointment">
        <b-form-group label="Nombre completo" label-for="name" v-if="!userStore.isAuthenticated">
          <b-form-input id="name" v-model="form.name" required />
        </b-form-group>

        <div v-else class="mb-3">
          <p><strong>Nombre:</strong> {{ userStore.user.name }}</p>
        </div>

        <b-form-group label="Teléfono de contacto" label-for="phone">
          <b-form-input id="phone" v-model="form.phone" required />
        </b-form-group>

        <div>
          <p class="mt-2"><strong>Precio:</strong> ${{ selectedService.price }}</p>
          <p><strong>Duración:</strong> {{ selectedService.duration }} minutos</p>
        </div>

        <div class="mb-3">
          <label><strong>Selecciona una fecha</strong></label>
          <div class="d-flex gap-2 overflow-auto py-2">
            <b-button
              v-for="day in availableDates"
              :key="day.value"
              size="sm"
              :variant="form.date === day.value ? 'primary' : 'outline-primary'"
              @click="form.date = day.value"
            >
              {{ day.label }}
            </b-button>
          </div>
        </div>

        <div class="mb-3">
          <label><strong>Selecciona una hora</strong></label>
          <div class="d-flex gap-2 flex-wrap">
            <b-button
              v-for="time in availableTimes"
              :key="time"
              size="sm"
              :variant="form.time === time ? 'primary' : 'outline-primary'"
              @click="form.time = time"
            >
              {{ time }}
            </b-button>
          </div>
        </div>

        <b-button type="submit" variant="primary" class="mt-2" :disabled="!form.time">Agendar</b-button>
      </b-form>
    </b-card>
  </div>
</template>

<script setup>
import { onMounted, ref, reactive, watch } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import { BCard, BForm, BFormGroup, BFormInput, BButton, BListGroup, BListGroupItem } from 'bootstrap-vue-3'
import { useUserStore } from '@/store/user'
import { format, addDays } from 'date-fns'

const route = useRoute()
const businessId = route.params.id

const business = ref(null)
const services = ref([])

const fetchBusiness = async () => {
  try {
    const response = await axios.get(`/api/businesses/${businessId}`)
    business.value = response.data
  } catch (error) {
    console.error('Error al cargar el negocio:', error)
  }
}

const fetchServices = async () => {
  try {
    const response = await axios.get(`/api/businesses/${businessId}/services`)
    services.value = response.data
  } catch (error) {
    console.error('Error al cargar servicios:', error)
  }
}

const userStore = useUserStore()

const form = reactive({
  name: '',
  phone: '',
  service: '',
  date: '',
  time: ''
})

if (userStore.isAuthenticated && userStore.user?.name) {
  form.name = userStore.user.name
}

const selectedService = ref(null)

const selectService = (service) => {
  selectedService.value = service
  form.service = service.id
}

const submitAppointment = async () => {
  if (!form.time) {
    alert('Por favor selecciona una hora antes de agendar.')
    return
  }

  try {
    const formattedTime = form.time.length === 5 ? `${form.time}:00` : form.time

    const payload = {
      name: form.name,
      phone: form.phone,
      service_id: form.service,
      business_id: businessId,
      date: form.date,
      time: formattedTime,
      customer_id: userStore.user.id
    }

    const response = await axios.post('/api/appointments', payload, {
      headers: {
        Authorization: `Bearer ${userStore.token}`
      }
    })
    console.log('Cita registrada:', response.data)
    alert('Cita agendada exitosamente')

    // Limpiar formulario después de agendar
    form.phone = ''
    form.time = ''
    form.date = ''
    selectedService.value = null
    availableTimes.value = []
    } catch (error) {
    console.error('Error al registrar la cita:', error)
    if (error.response?.data?.errors) {
        console.log('Errores de validación:', error.response.data.errors)
    }
    alert('Ocurrió un error al agendar la cita')
    }
}

onMounted(() => {
  fetchBusiness()
  fetchServices()
})

const availableDates = ref(
  Array.from({ length: 7 }, (_, i) => {
    const date = addDays(new Date(), i)
    return {
      value: format(date, 'yyyy-MM-dd'),
      label: format(date, 'EEE dd/MM', { locale: undefined })
    }
  })
)

const availableTimes = ref([])

const fetchAvailableTimes = async () => {
  if (!form.date || !selectedService.value) {
    console.log('No date or service selected yet')
    return
  }

  console.log('Consultando horarios:', {
    url: `/api/businesses/${businessId}/available-hours`,
    date: form.date,
    duration: selectedService.value.duration,
    service: selectedService.value
  })

  try {
    const response = await axios.get(`/api/businesses/${businessId}/available-hours`, {
      params: {
        date: form.date,
        duration: selectedService.value.duration
      }
    })
    console.log('Horarios recibidos:', response.data)
    availableTimes.value = response.data
  } catch (error) {
    console.error('Error al cargar horarios disponibles:', error)
    availableTimes.value = []
  }
}

watch(() => form.date, () => {
  fetchAvailableTimes()
})
</script>