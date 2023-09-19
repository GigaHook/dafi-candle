<template>
  <v-card
    class="fill-height d-flex flex-column justify-space-between px-4 pt-2 pb-3"
    elevation="3"
  >
    <h1 class="text-h5">Заказ №{{  }}</h1>

  </v-card>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({
  layout: AppLayout
})

const { order } = defineProps({
  order: Array
})
</script>

<style coped>

</style>