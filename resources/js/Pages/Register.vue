<template>
  <Head title="Регистрация"/>
  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col xs="12" sm="8" md="7" lg="5" xl="4">
        <v-card class="px-5 pb-4 pt-3">
          <v-form
            @submit.prevent="submit"
            ref="form"
            validate-on="blur"
            :readonly="loading"
          >
            <h1 class="text-h4 mb-3">Регистрация</h1>
            <FormInput
              name="name"
              v-model="formData.name"
              label="Имя"
              type="text"
              :rules="[rules.required, rules.length]"
              prepend-inner-icon="mdi-account"
            />
            <FormInput
              name="email"
              v-model="formData.email"
              label="E-mail"
              type="email"
              prepend-inner-icon="mdi-email"
              :rules="[rules.required, rules.length, rules.email]"
              :error-messages="formData.errors.email"
            />
            <FormInput
              name="tel"
              v-model="formData.tel"
              label="Телефон"
              type="tel"
              prepend-inner-icon="mdi-phone"
              v-mask="'+7 (###) ###-##-##'"
              :rules="[rules.required, rules.tel]"
              :error-messages="formData.errors.tel"
            />
            <FormInput
              name="password"
              v-model="formData.password"
              label="Пароль"
              type="password"
              hint="От 6 до 20 символов"
              :rules="[rules.required, rules.password]"
              prepend-inner-icon="mdi-key"
            />
            <div class="d-flex justify-space-between">
              <BtnPrimary type="submit" :loading="loading">
                Зарегистрироваться
              </BtnPrimary>
              <BtnSecondary @click="$inertia.get(route('login'))">
                Уже есть аккаунт?
              </BtnSecondary>
            </div>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const loading = ref(false)
const form = ref()
const formData = useForm({
  name:     null,
  email:    null,
  tel:      null,
  password: null,
})

const rules = {
  required: text => !!text || 'Это поле нужно заполнить',
  password: text => (text?.length >= 6 && text?.length <= 20) || 'От 6 до 20 символов',
  tel:      text => text?.length == 18 || 'Введите номер полностью',
  email:    text => (text?.includes('@') && text?.includes('.')) || 'Введите почту полностью',
  length:   text => text?.length <= 100 || 'Слишком длинное значение',
}

watch(() => formData.tel, () => {
  if (formData.errors.tel) {
    formData.clearErrors('tel')
  }
})

watch(() => formData.email, () => {
  if (formData.errors.email) {
    formData.clearErrors('email')
  }
})

function submit() {
  form.value.validate().then(() => {
    if (form.value.isValid) {
      formData.post(route('user.store'), {
        onStart: () => loading.value = true, 
        onFinish: () => loading.value = false,
      })
    }
  })
}
</script>

