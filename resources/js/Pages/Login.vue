<template>
  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col xs="12" sm="8" md="7" lg="5" xl="4">
        <v-card class="px-5 pb-5 pt-3">
          <v-form
            @submit.prevent="submit"
            ref="form"
            validate-on="blur"
            :readonly="loading"
          >
            <h1 class="text-h4 mb-4">Войти в аккаунт</h1>
            <v-tabs
              v-model="tab"
              fixed-tabs
            >
              <v-tab value="email">По почте</v-tab>
              <v-tab value="tel">По телефону</v-tab>
            </v-tabs>

            <v-window v-model="tab">
              <v-window-item value="email">
                <FormInput
                  v-model="formData.email"
                  label="E-mail"
                  type="email"
                  prepend-inner-icon="mdi-email"
                  class="mt-4"
                  :rules="[rules.requiredOne, rules.email, rules.length]"
                  :error-messages="formData.errors.email"
                />
              </v-window-item>

              <v-window-item value="tel">
                <FormInput
                  v-model="formData.tel"
                  label="Телефон"
                  type="tel"
                  prepend-inner-icon="mdi-phone"
                  v-mask="'+7 (###) ###-##-##'"
                  class="mt-4"
                  :rules="[rules.requiredOne, rules.tel]"
                  :error-messages="formData.errors.tel"
                />
              </v-window-item>
            </v-window>
            <FormInput
              v-model="formData.password"
              label="Пароль"
              type="password"
              prepend-inner-icon="mdi-key"
              hint="От 6 до 20 символов"
              :rules="[rules.required, rules.password]"
              :error-messages="formData.errors.password"
            />
            <div class="d-flex justify-space-between">
              <BtnPrimary type="submit" :loading="loading">
                Войти
              </BtnPrimary>
              <BtnSecondary @click="$inertia.get(route('user.create'))">
                Нет аккаунта?
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
const tab = ref('email')
const formData = useForm({
  email: null,
  tel: null,
  password: null,
})

const rules = {
  requiredOne:  () => !!(formData.email?.length || formData.tel?.length) || 'Заполните это поле',
  required:   text => !!text || 'Заполните это поле',
  password:   text => (text?.length >= 6 && text?.length <= 20) || 'От 6 до 20 символов',
  tel:        text => (tab.value != 'tel' || text?.length == 18) || 'Введите номер полностью',
  email:      text => (tab.value != 'email' || text?.includes('@') && text?.includes('.')) || 'Введите почту полностью',
  length:     text => text?.length <= 100 || 'Слишком длинное значение',
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

watch([() => formData.password, tab], () => {
  if (formData.errors.password) {
    formData.clearErrors('password')
  }
})

function submit() {
  form.value.validate().then(() => {
    if (form.value.isValid) {
      tab.value == 'email' ? formData.tel = '' : formData.email = ''
      formData.post(route('user.auth'), {
        onStart: () => loading.value = true,
        onFinish: () => loading.value = false,
      })
    }
  })
}
</script>
