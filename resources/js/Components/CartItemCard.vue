<template>
  <v-col cols="2">
    <v-img
      :src="`storage/upload/${product.image}`"
      class="w-100 rounded"
      style="aspect-ratio: 1 / 1;"
      cover
    >
      
    </v-img>
  </v-col>
  
  <v-col cols="6">
    <div class="text-h6">
      {{ product.name }}
    </div>
    <div class="text-subtitle-2">
      {{ product.price }} 
      <v-icon icon="mdi-currency-rub" size="16" class="ms-n1 mb-1"/>
    </div>
  </v-col>

  <v-col cols="2" class="d-flex justify-center">
    <v-btn
      variant="tonal"
      icon="mdi-minus"
      size="32"
      rounded="lg"
      color="primary"
      @click="$router.patch(route('cart.update', product.id))"
    />
    <div class="mx-4 pt-1">
      {{ product.quantity }}
    </div>
    <v-btn
      variant="tonal"
      icon="mdi-plus"
      size="32"
      rounded="lg"
      color="primary"
      @click="$router.post(route('cart.store'), { id: product.id })"
    />
  </v-col>
  
  <v-col cols="2" class="d-flex flex-column justify-space-between align-end">
    <div>
      {{ product.price * product.quantity }}
      <v-icon icon="mdi-currency-rub" size="16" class="ms-n1 mb-1"/>
    </div>
    <v-btn
      variant="plain"
      icon="mdi-delete-outline"
      @click="$router.delete(route('cart.destroy', product.id))"
    />
  </v-col>

  <v-divider v-if="!last" class="my-2"/>
</template>

<script setup>
defineProps({
  product: Object,
  last: Boolean
})
</script>

<style scoped>

</style>