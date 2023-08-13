<template>
  <v-container>
    <v-row>

      <v-col cols="9">
        <v-card class="px-4 py-2">
          <h2 class="text-h5">
            Корзина
          </h2>
          <v-row>
            <CartItemCard
              v-for="product in cart.items"
              :product="product"
            />
          </v-row>
        </v-card>
      </v-col>

      <v-col cols="3">
        <v-card class="px-4 pt-2 pb-4">
          Всего товаров: todo <br>
          На цену: todo <br>
          <BtnPrimary class="mt-1">Заказать</BtnPrimary>
        </v-card>
      </v-col>

    </v-row>
  </v-container>
</template>

<script setup>
import { defineComponent } from 'vue';
import CartItemCard from '../Components/CartItemCard.vue'

defineComponent({
  CartItemCard: CartItemCard
})

defineProps({
  cart: {
    type: Object,
    required: false,
  }
})
</script>

<script>
import AppLayout from '../Layouts/AppLayout.vue'

export default {
  layout: AppLayout
}
</script>

<style scoped>

</style>