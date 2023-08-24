<template>
  <Head title="Регистрация"/>
  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col xs="12" sm="8" md="7" lg="6" xl="4">
        <v-card class="px-5 pb-4 pt-3">
          <v-form
            @submit.prevent="submit"
            ref="form"
            validate-on="blur"
            :disabled="loading"
          >
            <h1 class="text-h4 mb-3">Регистрация</h1>
            <FormInput
              v-model="name"
              label="Имя"
              type="text"
              :rules="[rules.required]"
            />
            <FormInput
              v-model="email"
              label="E-mail"
              type="email"
              :rules="[rules.required]"
            />
            <FormInput
              v-model="tel"
              label="Телефон"
              type="tel"
              v-mask="'+7 (###) ###-##-##'"
              :rules="[rules.required]"
              ref="tel"
            />
            <FormInput
              v-model="password"
              label="Пароль"
              type="password"
              hint="От 6 до 20 символов"
              min="6"
              max="20"
              :rules="[rules.required, rules.length]"
            />
            <div class="d-flex justify-space-between">
              <BtnPrimary type="submit" :loading="loading">
                Зарегистрироваться
              </BtnPrimary>
              <BtnSecondary @click="$router.get(route('login'))">
                Уже есть аккаунт?
              </BtnSecondary>
            </div>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import AppLayout from '../Layouts/AppLayout.vue'
import FormInput from '../Components/FormInput.vue'
import { Head } from '@inertiajs/vue3'
export default {
  layout: AppLayout,
  components: {
    FormInput,
  },
  data() {
    return {
      name: null,
      email: null,
      tel: null,
      password: null,
      rules: {
        required: text => !!text || 'Это поле нужно заполнить',
        length: text => (text?.length >= 6 && text?.length <= 20) || 'От 6 до 20 символов',
      },
      loading: false,
    }
  },
  methods: {
    submit() {
      this.$refs.form.validate()
      if (this.$refs.form.isValid) 
      this.$router.post(route('user.store', {
        name: this.name,
        email: this.email,
        tel: this.tel,
        password: this.password
      }, {
        preserveScroll: true,
        onStart: this.loadingStart,
        onFinish: this.loadingEnd,
      }))
    },
    loadingStart() {
      this.loading = true
    },
    loadingEnd() {
      this.loading = false
    },
  }
}
</script>

<style scoped>

</style>