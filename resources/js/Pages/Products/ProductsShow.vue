<template>
  <Head :title="product.name"/>
  <v-container>
    <v-row class="justify-center">
      <v-col
        cols="12"
        offset-xl="4"
        offset-lg="2"
        offset-md="1"
      >
        <h1 class="text-h4">{{ product.name }}</h1>
      </v-col>

      <v-col xl="3" lg="4" md="5" sm="6" cols="12">
        <v-img
          :src="`../storage/upload/${product.image}`"
          style="aspect-ratio: 3 / 4;"
          class="mb-4 rounded"
          cover
        >
          <UnavailableChip v-if="!product.available"/>
        </v-img>

        <div class="d-flex w-100">
          <v-fade-transition group leave-absolute hide-on-leave>
            <v-btn
              v-if="!storedProduct"
              @click="store"
              :loading="loading"
              variant="text"
              color="primary"
              max-width="fit-content"
              :disabled="!product.available"
            >
              {{ buttonText }}
            </v-btn>

            <ProductControls
              v-else
              :quantity="quantity"
              :unavailable="!isAvailable"
              @store="store"
              @update="update"
            />

            <div v-if="storedProduct" class="ms-4 mt-3">
              <v-icon :icon="icon"/>
              {{ statusText }}
            </div>


          </v-fade-transition>

          <v-spacer/>

          <BtnBack class="mt-1"/>
        </div>
      </v-col>
      
      <v-col xl="5" lg="6" md="6" sm="6" cols="12">
        <v-card class="px-4 py-2">  
          <h2 class="text-h5">Описание</h2>
          {{ product.description }} <br><br>
          {{ product.type.name }}
          <span v-if="product.type.name != 'Саше'">свеча</span><br><br>
          <ListRow
            v-for="tag in tags"
            :left="tag.name"
            :right="tag.value"
          />

          <template v-if="product.available">
            В наличии {{ product.available }} шт
          </template>

          <template v-else>
            На данный момент нет в наличии
          </template>
        </v-card>
      </v-col>

    </v-row>
  </v-container>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import ListRow from '@/Components/ListRow.vue'
import useProduct from '@/Composables/useProduct'
import ProductControls from '@/Components/ProductControls.vue'
import UnavailableChip from '@/Components/UnavailableChip.vue'

import { defineComponent, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { useOrder } from '@/Composables/useOrder'

defineOptions({ layout: AppLayout })
const { product } = defineProps({ product: Object, tags: Array, })
defineComponent({ ListRow, ProductControls, UnavailableChip })

const page = usePage()

let storedProduct
let store
let update
let loading
let buttonText
let quantity
let isAvailable
let icon
let statusText

if (!page.props.order) {
  ({
    storedProduct,
    loading,
    store,
    update,
    quantity,
    isAvailable,
  } = useProduct(product))

  buttonText = 'Купить'
  icon = 'mdi-cart-check'
  statusText = 'В корзине'
} else {
  const {
    updateOrderItems,
    loading: orderLoading
  } = useOrder(page.props.order)

  loading = orderLoading
  const getStoredProduct = () => page.props.order.products.find(item => item.id == product.id)
  storedProduct = computed(getStoredProduct)
  quantity = computed(() => getStoredProduct().order_item.quantity)
  store = () => updateOrderItems('post', product.id)
  update = () => updateOrderItems('patch', product.id)
  buttonText = 'Добавить'
  icon = 'mdi-notebook-check-outline'
  statusText = 'В заказе'
  isAvailable = true
}

</script>
