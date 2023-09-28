<template>
  <Head title="Корзина"/>
  <v-container :fluid="display.md.value || display.lg.value">
    <v-row class="justify-center" v-if="$page.props.cart.items.length">

      <v-col cols="12" sm="12" md="8" lg="8" order="2" order-md="1">
        <v-card class="pa-4 pb-2" elevation="3">
          <v-scroll-x-transition group>

            <CartItemCard
              v-for="product in $page.props.cart.items"
              :key="product.id"
              :product="product"
              :last="product == $page.props.cart.items[$page.props.cart.items.length - 1]"
            />
            
            <v-divider class="my-2"/>

            <BtnSecondary @click="$router.get(route('cart.clear'))">
              Очистить корзину
            </BtnSecondary>

          </v-scroll-x-transition>
        </v-card>
      </v-col>

      <v-col cols="12" sm="12" md="4" lg="3" order="1" order-md="2">
        <v-card elevation="3">
          <v-row class="px-4 pt-3 mb-3">

            <v-col cols="12" sm="6" md="12">
              Всего товаров {{ $page.props.cart.totalQuantity }}
              <div class="text-h5">
                Итого {{ $page.props.cart.totalPrice }}
                <v-icon icon="mdi-currency-rub" size="24" class="ms-n1 mb-2"/>
              </div>

              <BtnPrimary
                @click="$router.get(route('orders.create'))"
                :disabled="!$page.props.user"
                class="mt-5 w-100"
              >
                Заказать
              </BtnPrimary>
            </v-col>

            <v-col cols="12" sm="6" md="12">
              <v-alert
                v-if="!$page.props.user"
                class="h-100 mt-2"
                type="info"
                variant="outlined"
                color="primary"
              >
                Сначала нужно зарегистрироваться или войти в аккаунт
              </v-alert>
            </v-col>

          </v-row>
        </v-card>
      </v-col>

    </v-row>

    <v-row v-else class="justify-center">
      <v-col cols="12" sm="8" md="7" lg="6" xl="4">
        <v-card class="text-center text-h5 pa-4 pt-2" elevation="3">
          Тут пока ничего нет<br>
          <BtnPrimary
            @click="$router.get(route('products.index'))"
            size="large"
            class="mt-2"
          >
            В каталог
          </BtnPrimary>
        </v-card>
      </v-col>
    </v-row>

  </v-container>
</template>

<script setup>
import { defineComponent } from 'vue'
import CartItemCard from '../Components/CartItemCard.vue'
import AppLayout from '../Layouts/AppLayout.vue'
import { useDisplay } from 'vuetify'

const display = useDisplay()

defineOptions({
  layout: AppLayout
})

defineComponent({
  CartItemCard: CartItemCard
})

</script>

<style scoped>

</style>