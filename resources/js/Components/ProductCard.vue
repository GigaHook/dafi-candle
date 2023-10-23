<template>
  <v-col xl="3" lg="3" md="4" sm="6" cols="12">
    <v-card
      class="fill-height d-flex flex-column justify-space-between"
      style="min-height: fit-content !important;"
      elevation="3"
    >
      <v-img
        :src="`storage/upload/${product.image}`"
        cover
        style="height: 320px"
        @mouseover="hover = true"
        @mouseleave="hover = false"
        v-ripple
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
      
      <!--for products index-->
      <div  
        class="d-flex flex-nowrap justify-space-between align-center ms-2 me-4"
        style="min-height: 52px !important;"
      >
        <v-btn
          v-if="!pageVariant.product"
          @click="addToCart"
          :loading="loading"
          variant="text"
          color="primary"
          max-width="fit-content"
        >
          {{ !order ? 'Купить' : 'Добавить' }}
        </v-btn>

        <ProductControls
          v-else
          :product="pageVariant.product"
          :method-names="pageVariant.methodNames"
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
import ProductControls from './ProductControls.vue'
import { ref, computed, defineComponent } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { useOrder } from '@/Composables/useOrder'

defineComponent({ ProductControls, })

const { product, order } = defineProps({
  product: Object,
  order: {
    type: Object,
    required: false,
  }
})

const hover = ref(false)
const loading = ref(false)
const page = usePage()
const { updateOrderItems } = useOrder(order)

const pageVariant = computed(() => {
  return order
    ? {
      product: order.products.find(item => item.id == product.id),
      store: () => updateOrderItems('store', product.id),
      update: () => updateOrderItems('patch', product.id),
      delete: () => updateOrderItems('delete', product.id),
    }
    : {
      product: page.props.cart.items.find(item => item.id == product.id),
      
      store: () => router.post(route('cart.store', product.id), { 
        preserveState: true,
        preserveScroll: true 
      }),

      update: () => router.patch(route('cart.patch'), { 
        id: product.id 
      }, { 
        preserveState: true,
        preserveScroll: true 
      }),

      delete: () => ''
    }
})

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
.overlay{
  transition: all .1s ease-in-out;
  font-size: 16px !important;
  cursor: pointer;
} 
.overlay:hover{
  color: white;
}
</style>