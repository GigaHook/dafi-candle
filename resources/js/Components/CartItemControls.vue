<template>
  <div class="d-flex my-2">
    <v-btn
      icon
      size="36"
      variant="tonal"
      rounded="lg"
      color="primary"
      @click="$router.patch(route('cart.update', product.id), { preserveState: true, preserveScroll: true })"
    >
      <v-icon icon="mdi-minus"/>
    </v-btn>
    
    <div class="mx-4 mt-1" style="font-size: 18px">
      {{ product.quantity }}
    </div>

    <v-btn
      icon
      size="36"
      variant="tonal"
      rounded="lg"
      color="primary"
      @click="$router.post(route('cart.store'), { id: product.id }, { preserveScroll: true })"
    >
      <v-icon icon="mdi-plus"/>
    </v-btn>
  </div>
</template>

<script setup>

defineProps({
  product: Object
})

</script>