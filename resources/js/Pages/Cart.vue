<template>
  <Head title="Корзина"/>
  <v-container>
    <v-row class="justify-center">

      <v-col cols="9">
        <v-card class="pa-4 pb-2" elevation="3">
            <v-scroll-x-transition v-if="cart.items.length" group>
              <CartItemCard
                v-for="product in cart.items"
                :key="product.id"
                :product="product"
                :last="product == cart.items[cart.items.length - 1]"
              />
            </v-scroll-x-transition>
          <div v-else>
            Нет предметов в корзине
          </div>
        </v-card>
      </v-col>

      <v-col cols="3" xl="2">
        <v-card class="px-4 pt-2 pb-4" elevation="3">
          Всего товаров: <AnimatedCounter :value="cart.totalQuantity" :duration="500"/> <br>
          На цену: <AnimatedCounter :value="cart.totalPrice" :duration="500"/><!--придумать что нибудь-->
          <v-icon icon="mdi-currency-rub" size="18" class="ms-n1 mb-1"/>
          
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