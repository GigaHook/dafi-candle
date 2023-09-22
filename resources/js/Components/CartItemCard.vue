<template>
  <v-row dense>
    <v-col cols="2">
      <v-img
        @mouseover="hover = true"
        @mouseleave="hover = false"  
        :src="`storage/upload/${product.image}`"
        class="w-100 rounded"
        style="aspect-ratio: 1 / 1;"
        cover
      >
      <v-overlay
          contained
          :model-value="hover"
          class="align-center justify-center text-button font-weight-bold"
          style="cursor: pointer;"
          scrim="black"
          @click="$router.get(route('products.show', product.id))"
        >
          Подробнее
        </v-overlay>
      </v-img>
    </v-col>
    
    <v-col cols="7">
      <div
        @mouseover="hover = true"
        @mouseleave="hover = false" 
        @click="$router.get(route('products.show', product.id))"
        class="text-h6 d-inline"
        style="cursor: pointer;"
      >
        {{ product.name }}
      </div>

      <div class="text-subtitle-1">
        {{ product.price }} 
        <v-icon icon="mdi-currency-rub" size="16" class="ms-n1 mb-1"/> <br>
      </div>

      <v-banner
        lines="two"
        class="pa-0"
        elevation="0"
        border="0"
        stacked
        :text="product.description"
      />
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
    
    <v-col cols="1" class="d-flex flex-column justify-space-between align-end">
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

    <v-col cols="12"><v-divider v-if="!last" class="my-2"/></v-col>
  </v-row>
</template>

<script setup>
import { ref } from 'vue'

const hover = ref(false)

defineProps({
  product: Object,
  last: Boolean
})
</script>

<style scoped>

</style>