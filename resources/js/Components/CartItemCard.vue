<template>
  <v-row dense>
    <v-col cols="12" sm="4" md="3">
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
          @click="$inertia.get(route('products.show', product.id))"
        >
          Подробнее
        </v-overlay>

        <UnavailableChip v-if="!product.available"/>
      </v-img>
    </v-col>
    
    <v-col cols="12" sm="6" md="6">
      <div
        @mouseover="hover = true"
        @mouseleave="hover = false" 
        @click="$inertia.get(route('products.show', product.id))"
        class="text-h6 d-inline"
        style="cursor: pointer;"
      >
        {{ product.name }}
      </div>

      <div class="text-subtitle-2">
        {{ product.price }} 
        <v-icon icon="mdi-currency-rub" size="16" class="ms-n1 mb-1"/>
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
  
    <v-col
      cols="6" md="2"
      :class="display.md.value && 'ms-n10'"
    >
      <ProductControls
        :quantity="product.quantity"
        :unavailable="!isAvailable"
        @store="store"
        @update="update"
      />
    </v-col>
    
    <v-spacer v-if="display.md"/>

    <v-col
      cols="6" md="1"
      class="d-flex flex-column justify-space-between align-end"
    >
      <div class="text-no-wrap">
        {{ product.price * product.quantity }}
        <v-icon icon="mdi-currency-rub" size="16" class="ms-n1 mb-1"/>
      </div>

      <v-btn
        variant="plain"
        icon="mdi-delete-outline"
        @click="$inertia.delete(route('cart.destroy', product.id), { 
          preserveScroll: true 
        })"
      />
    </v-col>

    <v-col v-if="!last" cols="12">
      <v-divider class="my-2"/>
    </v-col>
  </v-row>
</template>

<script setup>
import ProductControls from './ProductControls.vue'
import UnavailableChip from './UnavailableChip.vue'
import useProduct from '@/Composables/useProduct'

import { ref, defineComponent } from 'vue'
import { useDisplay } from 'vuetify'

defineComponent({ ProductControls, UnavailableChip })

const { product } = defineProps({ product: Object, last: Boolean })
const { store, update, isAvailable } = useProduct(product)
const display = useDisplay()
const hover = ref(false)
</script>