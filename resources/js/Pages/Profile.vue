<template>
  <v-container>
    <v-row>
      <v-col cols="8">

      </v-col>
      <v-col cols="4">
        Имя: {{ $page.props.user.name }} <br>
        Почта: {{ $page.props.user.email }} <br>
        Телефон: {{ $page.props.user.tel }} <br>
        <BtnPrimary @click="$router.post('/logout')">
          Выйти
        </BtnPrimary>
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