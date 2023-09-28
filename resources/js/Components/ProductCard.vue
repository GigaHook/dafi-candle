<template>
  <v-col xl="3" lg="3" md="4" sm="6" cols="12">
    <v-card
      @mouseover="hover = true"
      @mouseleave="hover = false"      
      class="fill-height d-flex flex-column justify-space-between"
      style="min-height: fit-content !important;"
      elevation="3"
    >
      <v-img
        :src="`storage/upload/${product.image}`"
        cover
        style="height: 320px"
      >
        <div class="d-flex justify-end">
          <v-btn
            v-if="$page.props.user?.is_admin"
            icon="mdi-pencil"
            class="ma-1"
            style="z-index: 4000;"
            @click="$router.get(route('products.edit', product.id))"
            size="40"
          />
  
          <v-btn
            v-if="$page.props.user?.is_admin"
            icon="mdi-delete"
            class="ma-1"
            style="z-index: 4000;"
            @click="$router.delete(route('products.destroy', product.id))"
            size="40"
          />
        </div>

        <v-overlay
          contained
          :model-value="hover"
          class="align-center justify-center text-button font-weight-bold overlay"
          scrim="black"
          @click="$router.get(route('products.show', product.id))"
        >
          Подробнее
        </v-overlay>
      </v-img>

      <div class="px-4 py-1 position-relative" style="min-height: 68px !important;">
        <v-slide-x-reverse-transition class="position-absolute right-0 ma-2">
          <v-icon
            v-if="$page.props.cart.items.find(item => item.id == product.id)"
            icon="mdi-cart-check"
            size="32"
            class="position-absolute"
          />
        </v-slide-x-reverse-transition>

        <div
          class="font-weight-bold text-h6 d-inline"
          style="cursor: pointer;"
          @click="$router.get(route('products.show', product.id))"  
        >
          {{ product.name }}
        </div>

        <div class="text-subtitle-1 me-auto">
          {{ product.type.name }}
          <span v-if="product.type.name != 'Саше'">свеча</span>
          <span v-else>&#x301;</span>
        </div>
      </div>

      <v-divider/>
      
      <div class="d-flex flex-nowrap justify-space-between align-center ms-2 me-4" style="min-height: 52px !important;">
        <v-btn
          v-if="!$page.props.cart.items.find(item => item.id == product.id)"
          @click="addToCart"
          :loading="loading"
          variant="text"
          color="primary"
          max-width="fit-content"
        >
          Купить
        </v-btn>

        <CartItemControls
          v-else
          :product="$page.props.cart.items.find(item => item.id == product.id)"
        />

        <div class="d-flex flex-nowrap align-center">
          {{ product.price }}
          <v-icon icon="mdi-currency-rub" size="18"/>
        </div>
      </div>

    </v-card>
  </v-col>
</template>

<script setup>
import { ref, defineComponent } from 'vue'
import { router } from '@inertiajs/vue3'
import CartItemControls from './CartItemControls.vue'

defineComponent({
  CartItemControls: CartItemControls,
})

const { product } = defineProps({
  product: Object
})

const hover = ref(false)
const loading = ref(false)

function addToCart() {
  router.post(route('cart.store'), {
    id: product.id
  }, {
    preserveScroll: true,
    onStart: () => loading.value = true,
    onFinish: () => loading.value = false,
  })
}

</script>

<style scoped>
.img-icon{
  position: absolute;
  right: 6px;
  top: 6px;
  background-color: #181818;
  border-radius: 5px;
  outline: 2px solid #181818;
}

.overlay{
  transition: all .1s ease-in-out;
  font-size: 16px !important;
  cursor: pointer;
} 
.overlay:hover{
  color: white;
}
</style>