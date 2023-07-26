<template>
  <Head title="Каталог"/>
  <v-container fluid>
    <v-row style="min-height: calc(100vh - 72px);">

      <!--FILTERS-->
      <v-col cols="12">
        <v-expansion-panels elevation="3" class="mb-n1" v-model="expanded">
          <v-expansion-panel density="compact" :value="true">

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
                    v-model="selectedTypes"
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
                    :items="[...sortValues.keys()]"
                    v-model="sortValue"
                    @update:model-value="sort"
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
    prevSortValue: String,
    prevExpanded: Boolean,
    prevSelectedTypes: Object
  },

  data() {
    return {
      sortValue: null,
      selectedTypes: [],
      filteredProducts: [],
      expanded: null,
    }
  },

  computed: {
    types() {
      return this.$page.props.types.map(elem => elem.name)
    },
    
    sortValues() {
      return new Map()
        .set('По возрастанию цены', 'price asc')
        .set('По убыванию цены', 'price desc')
        .set('Сначала старые', 'created_at asc')
        .set('Сначала новые', 'created_at desc')
        .set('В алфавитном порядке', 'name asc')
        .set('В обратном алфавитном порядке', 'name desc')
    },

    sortOptions() {
      const options = this.sortValues.get(this.sortValue).split(' ')
      return {
        sortBy: options[0],
        sortOrder: options[1],
        sortValue: this.sortValue,
        expanded: Number(!!this.expanded), //wtf idk
        selectedTypes: this.selectedTypes
      }
    },

  },

  methods: {
    sort() {
      this.$router.get(this.products.links[this.products.current_page].url, this.sortOptions)
    },

    next() {
      this.$router.get(this.products.next_page_url, this.sortOptions)
    },

    prev() {
      this.$router.get(this.products.prev_page_url, this.sortOptions)
    },

    toPage(page) {
      this.$router.get(this.products.links[page].url, this.sortOptions)
    },

    //TODO переделать на беке
    filter() {
      this.filteredProducts = this.products.data.filter(product => {
        return this.selectedTypes.includes(product.type.name)
      })

    }
  },

  watch: {
    //фильтрование при изменении выбранных типов
    selectedTypes(newValue) {
      if (!newValue.length) newValue[0] = this.types[0]
      this.filter()
    }
  },

  mounted() {
    this.sortValue = this.prevSortValue ?? 'Сначала новые'
    this.expanded = this.prevExpanded
    this.selectedTypes = this.prevSelectedTypes ?? this.types
    this.filter()
  },
}
</script>

<style scoped>
main{
  background-color:#191919;
}
</style>