<template>
  <Head :title="`Заказ от ${order.created_at.split('T')[0]}`"/>
  <v-container>
    <v-card
      class="fill-height d-flex flex-column justify-space-between px-4 pt-2 pb-3"
      elevation="3"
    >
      
  
    </v-card>
  </v-container>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({
  layout: AppLayout
})

const { order } = defineProps({
  order: Object
})
</script>

<style coped>

</style>