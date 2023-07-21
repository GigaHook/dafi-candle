<template>
  <Head title="Каталог"/>
  <v-container fluid>
    <v-row style="min-height: calc(100vh - 72px);">

      <v-col cols="12">
        <v-card elevation="3" class="px-4 py-2">
          
        </v-card>
      </v-col>
      
      <ProductCard
        v-for="product in products.data"
        :key="product.id"
        :product="product"
      />

      <v-col
        v-if="products.total > 12"
        cols="12"
        class="pt-4"
      >
        <v-pagination
          color="primary"
          :length="products.last_page"
          v-model="products.current_page"
          @next="$router.get(products.next_page_url)"
          @prev="$router.get(products.prev_page_url)"
          @update:modelValue="page => $router.get(products.links[page].url)"
        />
      </v-col>

    </v-row>
  </v-container>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue'
import ProductCard from '../../Components/ProductCard.vue'
export default {
  layout: AppLayout,
  components: {
    ProductCard,
  },
  props: {
    products: Object,
  },
  data() {
    return {

    }
  },

  mounted() {

  }
}
</script>

<style scoped>
main{
  background-color:#191919;
}
</style>