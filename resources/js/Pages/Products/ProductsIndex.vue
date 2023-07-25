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
                    :items="[...sortOptions.keys()]"
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
      sortValue: 'Сначала новые',
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
        .set('По возрастанию цены', 'price asc')
        .set('По убыванию цены', 'price desc')
        .set('Сначала старые', 'created_at desc')
        .set('Сначала новые', 'created_at asc')
        .set('В алфавитном порядке', 'name asc')
        .set('В обратном алфавитном порядке', 'name desc')
    },

  },

  methods: {
    next() {
      const options = this.sortOptions.get(this.sortValue).split(' ')
      this.$router.get(this.products.next_page_url, {
        sortBy: options[0],
        sortOrder: options[1],
      })
    },

    prev() {
      this.$router.get(this.products.prev_page_url)
    },

    toPage(page) {
      this.$router.get(this.products.links[page].url)
    },

    sort(field, order) {
      this.sortedProducts = this.products.data.slice().sort((a, b) => {
        let modifier = order === 'asc' ? 1 : -1
        if (a[field] < b[field]) return -modifier; 
        if (a[field] > b[field]) return modifier
        return 0
      })
    },

    filter() {
      this.filteredProducts = this.products.data.filter(product => {
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
    //this.sortValue = this.sortValue ?? this.sortOptions.keys[3]
    this.filterTypes = this.types
    this.filter()
  },
}
</script>

<style scoped>
main{
  background-color:#191919;
}
</style>