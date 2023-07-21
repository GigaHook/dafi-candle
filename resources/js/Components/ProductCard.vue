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
        :src="$page.props.storage + product.image"
        height="70%"
        cover
      >
        <v-overlay
          contained
          :model-value="hover"
          class="align-center justify-center"
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

<script>
export default {
  data() {
    return {
      hover: false,
    }
  },
  props: {
    product: Object,
  },
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