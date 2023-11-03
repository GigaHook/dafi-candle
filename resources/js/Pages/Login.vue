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
                  v-model="email"
                  label="E-mail"
                  type="email"
                  prepend-inner-icon="mdi-email"
                  class="mt-4"
                />
              </v-window-item>

              <v-window-item value="tel">
                <FormInput
                  v-model="tel"
                  label="Телефон"
                  type="tel"
                  prepend-inner-icon="mdi-phone"
                  v-mask="'+7 (###) ###-##-##'"
                  class="mt-4"
                />
              </v-window-item>
            </v-window>
            <FormInput
              v-model="password"
              label="Пароль"
              type="password"
              prepend-inner-icon="mdi-key"
              hint="От 6 до 20 символов"
              :rules="[rules.required, rules.password]"
              :error-messages="$page.props.errors.auth"
              @update:model-value="errorMessages = ''"
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
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const rules = {
  required: v => !!v || 'Введите пароль',
  password: v => (v?.length >= 6 && v?.length <= 20) || 'От 6 до 20 символов',
}

const loading = ref(false)
const form = ref()
const tab = ref('email')
const email = ref()
const tel = ref()
const password = ref()

async function submit() {
  form.value.validate().then(() => {
    if (form.value.isValid) {
      const formVariant = tab.value == 'tel' 
        ? {
          tel: tel.value,
          password: password.value,
        }
        : {
          email: email.value,
          password: password.value,
        }
      router.post(route('user.auth'), formVariant, {
        onStart: () => loading.value = true,
        onFinish: () => loading.value = false,
      })
    }
  })
}
</script>
