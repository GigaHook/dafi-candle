<template>
  <v-col
    xl="3" lg="3" md="4" sm="6"
    style="aspect-ratio: 4 / 5;"
  >
    <v-card
      @mouseover="hover = true"
      @mouseleave="hover = false"      
      class="fill-height d-flex flex-column justify-space-between"
      elevation="3"
    >
      <v-img
        :src="`storage/upload/${product.image}`"
        height="70%"
        cover
        class="position-relative"
      >
        <v-btn
          v-if="$page.props.user?.is_admin"
          icon="mdi-pencil"
          class="self-right position-absolute ma-1"
          style="right:0; z-index: 4000;"
          @click="$router.get(route('products.edit', product.id))"
          size="40"
        />

        <v-btn
          v-if="$page.props.user?.is_admin"
          icon="mdi-delete"
          class="self-right position-absolute ma-1"
          style="right:44px; z-index: 4000;"
          @click="$router.delete(route('products.destroy', product.id))"
          size="40"
        />

        <v-overlay
          contained
          :model-value="hover"
          class="align-center justify-center"
          scrim="black"
        >
          <BtnPrimary @click="$router.get(route('products.show', product.id))">
            Подробнее
          </BtnPrimary>
        </v-overlay>
      </v-img>

      <div class="px-4 py-1">
        <div class="font-weight-bold text-h6">{{ product.name }}</div>
        <div class="text-subtitle-1 me-auto">
          {{ product.type.name }}
          <span v-if="product.type.name != 'Саше'">свеча</span>
        </div>
      </div>

      <v-divider/>
      
      <div class="d-flex justify-space-between align-center pa-2">
        <v-btn
          @click="addToCart"
          :loading="loading"
          variant="text"
          color="primary"
          max-width="fit-content"
          class="px-2"
        >
          Купить
        </v-btn>

        <div class="ms-4">
          {{ product.price }}
          <v-icon icon="mdi-currency-rub" size="18" class="ms-n1 mb-1"/>
        </div>
      </div>

    </v-card>
  </v-col>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3';

const props = defineProps({
  product: Object
})

const hover = ref(false)
const loading = ref(false)

function addToCart() {
  router.post(route('cart.store'), {
    id: props.product.id
  }, {
    preserveScroll: true,
    onStart: () => { loading.value = true },
    onFinish: () => { loading.value = false },
  })
}

</script>

<script>
export default {
  name: 'ProductCard'
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
</style>