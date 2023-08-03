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
                    v-for="type in $page.props.types"
                    :key="type.id"
                    :value="type.id"
                    :label="type.name"
                    v-model="selectedTypes"
                    hide-details
                    density="compact"
                    color="primary"
                    multiple
                    disabled-class="disabled-switch"
                  />
                </v-col>

                <v-col md="4" sm="6" cols="12">
                  <p class="text-h6 mb-1">Сортировать по</p>
                  <v-select
                    variant="outlined"
                    density="compact"
                    :items="sortNames"
                    v-model="sortModelValue"
                    @update:model-value="update(products.links[products.current_page].url)"
                  />
                </v-col>

              </v-row>
            </v-expansion-panel-text>
            
          </v-expansion-panel>
        </v-expansion-panels>
      </v-col>
      
      <!--PRODUCTS-->
      <ProductCard
        v-if="!loading"
        v-for="product in products.data"
        :key="product.id"
        :product="product"
      />

      <v-col v-else cols="12" class="d-flex justify-center align-center">
        <v-progress-circular
          indeterminate
          color="primary"
          size="100"
        />
      </v-col>

      <!--PAGINATION-->
      <v-col
        cols="12"
        class="pt-4"
      >
        <v-pagination
          color="primary"
          :length="products.last_page"
          v-model="products.current_page"
          @next="update(products.next_page_url)"
          @prev="update(products.prev_page_url)"
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
      loading: false,
      sortModelValue: null,
      selectedTypes: [],
      sortValues: [
        {
          id: 1,
          name: 'По возрастанию цены',
          sortBy: 'price',
          sortOrder: 'asc',
        },{
          id: 2,
          name: 'По убыванию цены',
          sortBy: 'price',
          sortOrder: 'desc',
        },{
          id: 3,
          name: 'Сначала старые',
          sortBy: 'created_at',
          sortOrder: 'asc',
        },{
          id: 4,
          name: 'Сначала новые',
          sortBy:'created_at',
          sortOrder: 'desc',
        },{
          id: 5,
          name: 'В алфавитном порядке',
          sortBy: 'name',
          sortOrder: 'asc',
        },
      ],
      requestOptions: {
        preserveState: true,
        onStart: () => this.loading = true,
        onFinish: () => this.loading = false,
      }
    }
  },

  computed: {
    sortNames() {
      return this.sortValues.map(value => value.name)
    },

    requestData() {
      const sortValue = this.sortValues.find(value => value.name == this.sortModelValue)
      return {
        sortBy: sortValue.sortBy,
        sortOrder: sortValue.sortOrder,
        selectedTypes: this.selectedTypes
      }
    },

  },

  methods: {
    update(link) {
      this.$router.get(link, this.requestData, this.requestOptions)
    },

    toPage(page) {
      this.$router.get(this.products.links[page].url, this.requestData, this.requestOptions)
    },
  },

  mounted() {
    this.sortModelValue = 'Сначала новые'
    this.selectedTypes = this.$page.props.types.map(type => type.id)
    this.$watch('selectedTypes', () => {
      this.update(this.products.links[this.products.current_page].url)
    })
  },
}
</script>

<style scoped>
main{
  background-color:#191919;
}
.disabled-switch{
  background-color: darkgoldenrod;
}
</style>