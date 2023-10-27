<template>
  <Head :title="$page.props.order ? `Редактирование заказа №${$page.props.order.id}` : 'Каталог'"/>
  <v-toolbar
    color="surface"
    elevation="3"
    class="py-1 pe-1"
  >
    <v-text-field
      variant="outlined"
      color="primary"
      density="compact"
      class="mt-6 ms-4 "
      style="max-width: 550px;"
      label="Поиск"
      append-inner-icon="mdi-magnify"
      clearable
      v-model="searchText"
      @click:append-inner="update"
      @click:clear="update"
      @keyup.enter="update"
    > 
      <template #append>
        <div class="ms-n4">
          <ToolbarDropdown icon="mdi-format-list-bulleted-type">
            <v-list>            
              <v-list-subheader>
                ТИПЫ
              </v-list-subheader>
              <v-divider/>

              <v-list-item
                v-for="productType in types"
                :key="productType.id"
              >
                <v-switch
                  :value="productType.id"
                  v-model="selectedTypes"
                  @update:model-value="update"
                  density="compact"
                  class="ms-2"
                  color="primary"
                  hide-details
                  multiple
                >
                  <template #label>
                    <span class="ps-2">
                      {{ productType.name }}
                    </span>
                  </template>
                </v-switch>
              </v-list-item>
            </v-list>
          </ToolbarDropdown>

          <ToolbarDropdown icon="mdi-sort">
            <v-list :selected="[selectedSort]" color="primary">
              <v-list-subheader>
                СОРТИРОВКА
              </v-list-subheader>
              <v-divider/>

              <v-list-item
                v-for="(sort, i) in sorts"
                :key="i"
                :title="sort.title"
                :value="sort"
                @click="setSort(sort)"
              />
            </v-list>
          </ToolbarDropdown>
        </div>
      </template>
    </v-text-field>
    <v-spacer/>

    <template v-if="$page.props.order">
      <BtnPrimary
        variant="elevated"
        @click="$inertia.get(route('orders.show', $page.props.order.id))"
      >
        Вернуться к заказу
      </BtnPrimary>
    </template>

  </v-toolbar>

  <v-container fluid>  
    <v-row>
      <!--PRODUCTS-->
      <template v-if="!loading">
        <template v-if="$page.props.order">
          <ProductCardOrderEdit
          v-for="product in products.data"
          :key="product.id"
          :product="product"
          />
        </template>

        <template v-else>
          <ProductCard
            v-for="product in products.data"
            :key="product.id"
            :product="product"
          />
        </template>
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
import AppLayout from '@/Layouts/AppLayout.vue'
import ProductCard from '@/Components/ProductCard.vue'
import ProductCardOrderEdit from '@/Components/ProductCardOrderEdit.vue'
import ToolbarDropdown from '@/Components/ToolbarDropdown.vue'

import { ref, watch, onBeforeUnmount, defineComponent } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })
defineComponent({ ProductCard, ProductCardOrderEdit, ToolbarDropdown })

const { products, types } = defineProps({ 
  products: Object, 
  types: Object,
})

const sorts = [
  {
    title: 'Сначала новые',
    options: { sortBy:'created_at', sortOrder: 'desc'}
  }, 
  {
    title: 'По возрастанию цены',
    options: { sortBy: 'price', sortOrder: 'asc'}
  }, 
  {
    title: 'По убыванию цены',
    options: { sortBy: 'price', sortOrder: 'desc'}
  },
  {
    title: 'В алфавитном порядке',
    options: { sortBy: 'name', sortOrder: 'asc'}
  }
]

const page = usePage()
const loading = ref(false)
const selectedTypes = ref(types.map(type => type.id))
const selectedSort = ref(sorts[1]) 
const searchText = ref()

watch(selectedTypes, (oldTypes) => {
  if (oldTypes.length == 0) {
    selectedTypes.value[0] = types[0].id
  }
})

const requestOptions = {
  preserveState: true,
  onStart: () => loading.value = true,
  onFinish: () => loading.value = false,
}

function requestData() {
  return {
    sortBy: selectedSort.value.options.sortBy,
    sortOrder: selectedSort.value.options.sortOrder,
    selectedTypes: selectedTypes.value,
    searchText: searchText.value,
  }
}

function routeData() {
  return page.props.order ? 'orders.edit' : 'products.index'
}

function update() {
  router.get(route(routeData()), requestData(), requestOptions)
}

function toPage(pageNumber) {
  router.get(route(routeData()), {...requestData(), page: pageNumber}, requestOptions)
}

function setSort(sort) {
  selectedSort.value = sort
  update()
}

//if (page.props.order) {
//  onBeforeUnmount(() => {
//    router.post(route('orders.edit.finish'))
//  })
//}
</script>