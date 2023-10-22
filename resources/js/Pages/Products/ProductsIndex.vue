<template>
  <Head title="Каталог"/>
  <v-toolbar
    color="surface"
    elevation="3"
  >
    <v-text-field
      variant="outlined"
      color="primary"
      density="compact"
      style="max-width: 450px;"
      class="mt-6 ms-3"
      placeholder="Поиск"
      append-inner-icon="mdi-magnify"
      clearable
      v-model="searchText"
      :loading="searching"
      
    />
  </v-toolbar>

  <v-container fluid>  
    <v-row>
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
                    v-for="productType in $page.props.types"
                    :key="productType.id"
                    :value="productType.id"
                    :label="productType.name"
                    v-model="selectedTypes"
                    @update:model-value="update"
                    hide-details
                    density="compact"
                    color="primary"
                    multiple
                  />
                </v-col>

                <v-col md="4" sm="6" cols="12">
                  <p class="text-h6 mb-1">Сортировать по</p>
                  <v-select
                    variant="outlined"
                    v-model="sortSelect"
                    density="compact"
                    :items="sorts"
                    item-title="name"
                    item-value="options"
                    return-object
                    @update:model-value="update"
                  />
                </v-col>

              </v-row>
            </v-expansion-panel-text>
            
          </v-expansion-panel>
        </v-expansion-panels>
      </v-col>
      
      <!--PRODUCTS-->
      <template v-if="!loading">
        <ProductCard
          v-for="product in products.data"
          :key="product.id"
          :product="product"
        />
      </template>

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
<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import ProductCard from '../../Components/ProductCard.vue'
import { ref, toRef, reactive, computed, defineComponent } from 'vue'
import { router } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })
defineComponent({ ProductCard })

const { products, types } = defineProps({ 
  products: Object, 
  types: Object 
})

const sorts = [
  {
    name: 'По возрастанию цены',
    options: { sortBy: 'price', sortOrder: 'asc'}
  }, 
  {
    name: 'По убыванию цены',
    options: { sortBy: 'price', sortOrder: 'desc'}
  }, 
  {
    name: 'Сначала старые',
    options: { sortBy: 'created_at', sortOrder: 'asc'}
  }, 
  {
    name: 'Сначала новые',
    options: { sortBy:'created_at', sortOrder: 'desc'}
  }, 
  {
    name: 'В алфавитном порядке',
    options: { sortBy: 'name', sortOrder: 'asc'}
  }
]

const loading = ref(false)
const selectedTypes = ref(types.map(type => type.id))
const sortSelect = ref(sorts[3]) 
const searchText = ref()
const searching = ref(false)

function requestData() {
  return {
    sortBy: sortSelect.value.options.sortBy,
    sortOrder: sortSelect.value.options.sortOrder,
    selectedTypes: selectedTypes.value,
  }
}

const requestOptions = {
  preserveState: true,
  onStart: () => loading.value = true,
  onFinish: () => loading.value = false,
}

function update() {
  router.get(route('products.index'), requestData(), requestOptions)
}

function toPage(pageNumber) {
  router.get(route('products.index'), {...requestData(), page: pageNumber}, requestOptions)
}
</script>