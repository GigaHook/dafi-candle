<template>
  <v-img src="img" class="position-absolute" cover>
    <template #sources>
      <source srcset="../../../public/storage/assets/images/main2.jpg">
    </template>
  </v-img>
  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col sm="9" md="7" lg="5" xl="4" xs="10">
        <v-card class="px-4 pb-4 pt-2">
          <v-form>
            <h1 class="text-h4 mb-3">Регистрация</h1>
            <v-text-field
              class="mb-2"
              variant="outlined"
              density="compact"
              label="Телефон"
              name="tel"
              type="tel"
            />
            <v-text-field
              class="mb-2"
              variant="outlined"
              density="compact"
              label="Пароль"
              type="password"
              name="password"
              hint="От 6 до 20 символов"
              min="6"
              max="20"
            />
            <v-text-field
              class="mb-2"
              variant="outlined"
              density="compact"
              label="E-mail"
              type="email"
              name="email"
              hint="Не обязательно"
              persistent-hint
            />
            <v-btn class="mb-2" color="primary">
              Зарегистрироваться
            </v-btn><br>
            Уже есть аккаунт?<br>
            <v-btn class="" color="primary" @click="$router.get('/login')">
              Войти
            </v-btn>
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

  }
</script>

<style scoped>

</style>