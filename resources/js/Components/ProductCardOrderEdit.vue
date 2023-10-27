<template>
  <v-col xl="3" lg="3" md="4" sm="6" cols="12">
    <v-card
      class="fill-height d-flex flex-column justify-space-between"
      style="min-height: fit-content !important;"
      elevation="3"
    >
      <v-img
        :src="`../../storage/upload/${product.image}`"
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
            @click="$inertia.get(route('products.edit', product.id))"
            size="40"
          />
  
          <v-btn
            v-if="$page.props.user?.is_admin"
            icon="mdi-delete"
            class="ma-1"
            style="z-index: 4000;"
            @click="$inertia.delete(route('products.destroy', product.id))"
            size="40"
          />
        </div>

        <v-overlay
          contained
          :model-value="hover"
          class="align-center justify-center text-button font-weight-bold overlay"
          scrim="black"
          @click="$inertia.get(route('products.show', product.id))"
        >
          Подробнее
        </v-overlay>
      </v-img>

      <div class="px-4 py-1 position-relative" style="min-height: 68px !important;">
        <v-slide-x-reverse-transition class="position-absolute right-0 ma-2">
          <v-icon
            v-if="orderProduct"
            icon="mdi-cart-check"
            size="32"
            class="position-absolute"
          />
        </v-slide-x-reverse-transition>

        <div
          class="font-weight-bold text-h6 d-inline"
          style="cursor: pointer;"
          @click="$inertia.get(route('products.show', product.id))"  
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
      
      <div  
        class="d-flex flex-nowrap justify-space-between align-center ms-2 me-4"
        style="min-height: 52px !important;"
      >
        <v-btn
          v-if="!orderProduct"
          @click="updateOrderItems('post', product.id)"
          :loading="loading"
          variant="text"
          color="primary"
          max-width="fit-content"
        >
          Добавить
        </v-btn>

        <ProductControls
          v-else
          :product="orderProduct"
          :quantity="orderProduct.order_item.quantity"
          @store="updateOrderItems('post', product.id)"
          @update="updateOrderItems('patch', product.id)"
        />

        {{ orderProduct?.order_item.quantity }}


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
import { useOrder } from '@/Composables/useOrder'
import { usePage } from '@inertiajs/vue3'

defineComponent({ ProductControls })

const { product } = defineProps({ 
  product: Object,
})
const page = usePage()
const hover = ref(false)
const loading = ref(false)
const { updateOrderItems } = useOrder(page.props.order)
const orderProduct = computed(() => page.props.order.products.find(item => item.id == product.id))
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