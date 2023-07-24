<template>
  <Head title="Каталог"/>
  <v-container fluid>
    <v-row style="min-height: calc(100vh - 72px);">

      <!--FILTERS-->
      <v-col cols="12">
        <v-expansion-panels elevation="3" class="mb-n1">
          <v-expansion-panel density="compact">

            <v-expansion-panel-title class="text-h6">
              Фильтры
            </v-expansion-panel-title>

            <v-expansion-panel-text>
              <v-row dense>

                <v-col md="2" sm="6" cols="12">
                  <p class="text-h6">Тип</p>
                  <v-switch
                    v-for="type in types"
                    :key="type"
                    :value="type"
                    :label="type"
                    v-model="filterTypes"
                    hide-details
                    density="compact"
                    color="primary"
                  />
                </v-col>

                <v-col md="4" sm="6" cols="12">
                  <p class="text-h6 mb-1">Сортировать по</p>
                  <v-select
                    variant="outlined"
                    density="compact"
                    :items="[...sortOptions.values()]"
                    v-model="sortValue"
                  />
                </v-col>

              </v-row>
            </v-expansion-panel-text>
            
          </v-expansion-panel>
        </v-expansion-panels>
      </v-col>
      
      <!--PRODUCTS-->
      <ProductCard
        v-for="product in filteredProducts"
        :key="product.id"
        :product="product"
      />

      <!--PAGINATION-->
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
    sortValue: {
      type: String,
      default:
    }
  },

  data() {
    return {
      sortValue: null,
      sortedProducts: [],
      filterTypes: [],
      filteredProducts: [],
    }
  },

  computed: {
    types() {
      return this.$page.props.types.map(elem => elem.name)
    },
    
    sortOptions() {
      return new Map()
        .set('price asc', 'По возрастанию цены')
        .set('price desc', 'По убыванию цены')
        .set('created_at asd', 'Сначала старые')
        .set('created_at desc', 'Сначала новые')
        .set('name asd', 'В алфавитном порядке')
        .set('name desc', 'В обратном алфавитном порядке')
    },

    allOptions() {
      return {

      }
    }
  },

  methods: {
    sort(field, order) {
      this.sortedProducts = this.products.data.slice().sort((a, b) => {
        let modifier = order === 'asc' ? 1 : -1
        if (a[field] < b[field]) return -modifier; 
        if (a[field] > b[field]) return modifier
        return 0
      })
    },

    filter() {
      this.filteredProducts = this.sortedProducts.filter(product => {
        return this.filterTypes.includes(product.type.name)
      })

    }
  },

  watch: {
    filterTypes(newValue) {
      if (newValue.every(v => !v)) newValue[0] = this.types[0]
      this.filter()
    }
  },



  mounted() {
    if (this.sortValue == null) this.sortValue = this.sortOptions.get('created_at desc')
    this.filterTypes = this.types
    this.sort('name', 'asc')
    this.filter()
  },
}
</script>

<style scoped>
main{
  background-color:#191919;
}
</style>