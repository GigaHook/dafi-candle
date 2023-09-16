<template>
  
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({
  layout: AppLayout
})

const { orders } = defineProps({
  orders: Array
})
</script>

<style coped>

</style>