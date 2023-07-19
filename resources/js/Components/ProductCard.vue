<template>
  <v-col
    xl="3" lg="3" md="4" sm="6"
    class="card"
  >
    <v-card
      @mouseover="hover = true"
      @mouseleave="hover = false"
      class="fill-height d-flex flex-column justify-space-between"
      color="grey-darken-4"
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
        <div class="ms-4">
          {{ product.price }}
          <v-icon icon="mdi-currency-rub" size="18" class="ms-n1 mb-1"/>
        </div>
        
        <v-btn
          variant="text"
          color="primary"
          max-width="fit-content"
          class="px-2"
        >
          Купить
        </v-btn>
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
  }
}
</script>

<style scoped>
.card{
  aspect-ratio: 4 / 5;
}
</style>