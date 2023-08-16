<template>
  <v-col cols=12>
    <v-row>
      <v-col cols="3">
        {{ product.name }}
      </v-col>
      <v-col cols="3">
        {{ product.quantity }}
      </v-col>
      <v-col cols="3">
        {{ product.price }}
      </v-col>
      <v-col cols="3">
        {{ product.price * product.quantity }}
      </v-col>
    </v-row>
  </v-col>
</template>

<script setup>
defineProps({
  product: Object
})
</script>

<style scoped>

</style>