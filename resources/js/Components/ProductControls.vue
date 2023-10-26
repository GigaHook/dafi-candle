<template>
  <div class="d-flex my-2">
    <v-btn
      icon
      size="36"
      variant="tonal"
      rounded="lg"
      color="primary"
      @click="$emit('update')"
    >
      <v-icon icon="mdi-minus"/>
    </v-btn>
    
    <div class="mx-4 mt-1" style="font-size: 18px">
      {{ quantity }}
    </div>

    <v-btn
      icon
      size="36"
      variant="tonal"
      rounded="lg"
      color="primary"
      @click="$emit('store')"
    >
      <v-icon icon="mdi-plus"/>
    </v-btn>
  </div>
</template>

<script setup>
defineProps({
  product: Object,
  quantity: Number,
})
</script>











