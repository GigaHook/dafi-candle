<template>
  <Head title="Каталог"/>

  <v-container fluid>
    <v-row style="min-height: calc(100vh - 72px);">

      <v-col
        style="background-color: #ccc;"
        cols="12"
      >
        Фильтры
      </v-col>

      <ProductCard
        v-for="product in products.data"
        :product="product"
      />
      
      <v-col cols="12" class="pt-4">
        <v-pagination
          :length="products.last_page"
          v-model="products.current_page"
          @next="next"
          @prev="prev"
          @update:modelValue="toPage"
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
  methods: {
    next() {
      this.$router.get(this.products.next_page_url)
    },
    prev() {
      this.$router.get(this.products.prev_page_url)
    },
    toPage(page) {
      this.$router.get(this.products.links[page].url)
    }

  },
  mounted() {

  }
}
</script>

<style scoped>

</style>