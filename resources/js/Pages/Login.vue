<template>
  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col xs="12" sm="8" md="7" lg="6" xl="4">
        <v-card class="px-5 pb-5 pt-3">
          <v-form @submit.prevent="submit">
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
                  class="mt-4"
                />
              </v-window-item>
              <v-window-item value="tel">
                <FormInput
                  v-model="tel"
                  label="Телефон"
                  type="tel"
                  class="mt-4"
                />
              </v-window-item>
            </v-window>
            <FormInput
              v-model="password"
              label="Пароль"
              type="password"
              hint="От 6 до 20 символов"
              min="6"
              max="20"
            />
            <div class="d-flex justify-space-between">
              <BtnPrimary type="submit">
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

<script>
import AppLayout from '../Layouts/AppLayout.vue'

export default {
  layout: AppLayout,
  data() {
    return {
      tab: null,
      email: null,
      tel: null,
      password: null,
    }
  },
  methods: {
    submit() {
      if (this.tab == 'tel') {
        this.$inertia.post(route('user.auth'), {
          tel: this.tel,
          password: this.password,
        })
        return
      }
      if (this.tab == 'email') {
        this.$inertia.post(route('user.auth'), {
          email: this.email,
          password: this.password,
        })
      }
    }
  }
}
</script>

<style scoped>

</style>


  <!--<v-btn @click="$inertia.get('/')">
    назад
  </v-btn><br>
  <v-btn class="" color="primary">
    Войти
  </v-btn><br>
  Нет аккаунта?<br>
  <v-btn class="" color="primary" variant="outlined" @click="$inertia.get('/register')">
    Зарегистрироваться
  </v-btn>-->
