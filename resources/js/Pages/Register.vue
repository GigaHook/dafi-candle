<template>
  <v-img src="img" class="position-absolute" cover eager>
    <template #sources>
      <source srcset="../../../public/storage/assets/images/main2.jpg">
    </template>
  </v-img>
  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col sm="9" md="7" lg="5" xl="4" xs="10">
        <v-card class="px-5 pb-4 pt-3" color="black">
          <v-form @submit.prevent="submit">
            <h1 class="text-h4 mb-3">Регистрация</h1>
            <FormInput
              v-model="name"
              label="Имя"
              name="name"
              type="text"
            />
            <FormInput
              v-model="email"
              label="E-mail"
              type="email"
              name="email"
            />
            <FormInput
              v-model="tel"
              label="Телефон"
              name="tel"
              type="tel"
            />
            <FormInput
              v-model="password"
              label="Пароль"
              type="password"
              name="password"
              hint="От 6 до 20 символов"
              min="6"
              max="20"
            />
            <div class="d-flex justify-space-between">
              <BtnPrimary type="submit">
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
    }
  },
  methods: {
    submit() {
      this.$router.post(route('user.store', {
        name: this.name,
        email: this.email,
        tel: this.tel,
        password: this.password
      }))
    }
  }
}
</script>

<style scoped>

</style>