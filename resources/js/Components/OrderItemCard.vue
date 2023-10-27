<template>
  <v-row dense>
    <v-col md="3" sm="4" cols="12">
      <v-img
        @mouseover="hover = true"
        @mouseleave="hover = false"  
        :src="`../storage/upload/${product.image}`"
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
      </v-img>
    </v-col>

    <v-col cols="5">
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
        x{{ product.order_item.quantity }}
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
      v-if="editable"
      cols="4"
      class="text-right d-flex flex-column justify-space-between"
    >
      <div>
        {{ product.price * product.order_item.quantity }}
        <v-icon icon="mdi-currency-rub" size="16" class="ms-n1 mb-1"/><br>
      </div>

      <div>
        <v-btn
          icon
          variant="plain"
          @click="updateOrderItems('patch', product.id)"
        >
          <v-icon icon="mdi-minus"/>
        </v-btn>

        x{{ product.order_item.quantity }}

        <v-btn
          icon
          variant="plain"
          @click="updateOrderItems('post', product.id)"
        >
          <v-icon icon="mdi-plus"/>
        </v-btn>

        <v-btn
          icon
          variant="plain"
        >
          <v-icon icon="mdi-delete-outline"/>
          <Modal
            text="Удалить предмет заказа?"
            @confirm="updateOrderItems('delete', product.id)"
          />
        </v-btn>
      </div>
    </v-col>

    <v-col cols="12">
      <v-divider class="my-2"/>
    </v-col>
  </v-row>
</template>

<script setup>
import { ref } from 'vue'
import { useOrder } from '@/Composables/useOrder'

const { product, order } = defineProps({
  product: Object,
  order: Object,
  editable: {
    type: Boolean,
    required: false,
    default: false,
  },
})

const hover = ref(false)

const { updateOrderItems } = useOrder(order)
</script>
