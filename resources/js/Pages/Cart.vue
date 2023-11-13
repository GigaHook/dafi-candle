<template>
  <Head title="Корзина"/>
  <v-container :fluid="display.md.value || display.lg.value">
    <v-row class="justify-center" v-if="$page.props.cart.items.length">

      <v-col cols="12" sm="12" md="8" lg="8" order="2" order-md="1">
        <v-card class="pa-4" elevation="3">
          <CartItemCard
            v-for="product in products.available"
            :key="product.id"
            :product="product"
            :last="product.id == products.available.at(-1).id"
          />

          <template v-if="products.unavailable.length > 0">
            <v-divider class="my-4"/>
  
            <h3 class="text-h6 mb-2">
              Недоступные
            </h3>
  
            <CartItemCard
              v-for="product in products.unavailable"
              :key="product.id"
              :product="product"
              :last="product.id == products.unavailable.at(-1).id"
            />
          </template>
        </v-card>
      </v-col>

      <v-col cols="12" sm="12" md="4" lg="3" order="1" order-md="2">
        <v-card elevation="3">
          <v-row class="px-4 pt-3 mb-1">
            <v-col cols="12" sm="6" md="12">
              Всего товаров {{ $page.props.cart.totalQuantity }}
              <div class="text-h5">
                Итого {{ $page.props.cart.totalPrice }}
                <v-icon icon="mdi-currency-rub" size="24" class="ms-n1 mb-1"/>

                <v-btn
                  icon
                  variant="plain"
                  class="position-absolute"
                  :class="display.sm.value && !$page.props.user ? 'bottom-2 left-2' : 'top-2 right-2'"
                >
                  <v-icon icon="mdi-cart-remove" size="24"/>
                  <Modal
                    @confirm="$inertia.get(route('cart.clear'))"
                    :title="'Удалить все предметы из корзины?'"
                    :confirm-text="'Удалить'"
                  />
                </v-btn>
              </div>

              <BtnPrimary
                v-if="products.unavailable.length == 0"
                :disabled="!$page.props.user"
                class="w-100 mt-2"
                @click="$inertia.get(route('orders.create'))"
              >
                Заказать
              </BtnPrimary>

              <BtnPrimary
                v-else
                :disabled="!$page.props.user"
                class="w-100 mt-2"
              >
                Заказать
                <Modal 
                  @confirm="$inertia.get(route('orders.create'))"
                  title="Внимание"
                  text="В корзине имеются товары, которых на данный момент нет в наличии. Они не будут включены в заказ."
                />
              </BtnPrimary>
            </v-col>

            <v-col v-if="!$page.props.user" cols="12" sm="6" md="12">
              <v-alert
                class="h-100"
                type="info"
                variant="outlined"
                color="primary"
                :min-height="display.sm.value && '150px'"
              >
                Чтобы оформить заказ, нужно зарегистрироваться или войти в аккаунт.<br>
                <BtnPrimary @click="$inertia.get(route('orders.create'))" class="mt-2">
                  Войти
                </BtnPrimary>
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
            @click="$inertia.get(route('products.index'))"
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
import AppLayout from '../Layouts/AppLayout.vue'
import CartItemCard from '../Components/CartItemCard.vue'

import { computed, defineComponent } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { useDisplay } from 'vuetify'

const display = useDisplay()
const page = usePage()

const products = computed(() => {
  const available = []
  const unavailable = []
  page.props.cart.items.forEach(item => {
    if (item.available > 0) {
      available.push(item)
    } else {
      unavailable.push(item)
    }
  })

  return {
    available, unavailable
  }
})

defineOptions({ layout: AppLayout })
defineComponent({ CartItemCard })
</script>