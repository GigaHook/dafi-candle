<template>
  <v-btn @click="$router.get('/')">
    назад
  </v-btn><br>
  <v-btn class="" color="primary">
    Войти
  </v-btn><br>
  Нет аккаунта?<br>
  <v-btn class="" color="primary" variant="outlined" @click="$router.get('/register')">
    Зарегистрироваться
  </v-btn>
</template>

<script>
  import AppLayout from '../Layouts/AppLayout.vue'
  export default {
    layout: AppLayout,

  }
</script>

<style scoped>

</style>