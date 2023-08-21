<template>
  <Head title="Корзина"/>
  <v-container>
    <v-row class="justify-center">

      <v-col cols="9">
        <v-card class="pa-4 pt-2" elevation="3">
          <h2 class="text-h5 mb-2">
            Корзина
          </h2>
          <v-row dense v-if="cart.items.length">
            <CartItemCard
              v-for="product in cart.items"
              :key="product.id"
              :product="product"
              :last="product == cart.items[cart.items.length - 1]"
            />
          </v-row>
          <div v-else>
            Нет предметов в корзине
          </div>
        </v-card>
      </v-col>

      <v-col cols="3" xl="2">
        <v-card class="px-4 pt-2 pb-4" elevation="3">
          Всего товаров: {{ cart.totalQuantity }} <br>
          На цену: {{ cart.totalPrice }} <br>
          <div class="d-flex justify-space-between align-center mt-2">
            <BtnPrimary @click="$router.get(route('orders.create'))" class="mt-1">
              Заказать
            </BtnPrimary>
            <BtnSecondary @click="$router.get(route('cart.clear'))">
              Очистить
            </BtnSecondary>
          </div>
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
  cart: Object,
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