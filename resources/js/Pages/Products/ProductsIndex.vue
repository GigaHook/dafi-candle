<template>
  <Head :title="$page.props.order ? `Редактирование заказа №${$page.props.order.id}` : 'Каталог'"/>
  <v-toolbar
    color="surface"
    elevation="3"
    class="py-1"
  >
    <v-container :fluid="display.mdAndDown.value">
      <v-text-field
        variant="outlined"
        color="primary"
        density="compact"
        class="mt-6"
        style="width: 800px;"
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
                  @click="selectedSort = sort"
                />
              </v-list>
            </ToolbarDropdown>

            <v-btn
              icon
              color="grey"
              variant="outlined"
              class="ms-2"
              rounded
              @click="showUnavailable = !showUnavailable"
              :active="showUnavailable"
            >
              <v-icon
                color="grey-lighten-1"
                :icon="showUnavailable ? 'mdi-archive-remove' : 'mdi-archive-remove-outline'"
              />
              <v-tooltip
                activator="parent"
                open-delay="300"
                location="bottom"
              >
                Показать недоступные товары
              </v-tooltip>
            </v-btn>

            <BtnPrimary
              v-if="$page.props.order"
              @click="$inertia.post(route('orders.edit.finish'))"
              variant="elevated"
              class="ms-2"
            >
              Завершить редактирование
            </BtnPrimary>
          </div>
        </template>
      </v-text-field>
    </v-container>
  </v-toolbar>

  <v-container :fluid="display.mdAndDown.value"> 
    <v-row>
      <!--PRODUCTS-->
      <template v-if="!loading">
        <ProductCard
          v-for="product in products.data"
          :key="product.id"
          :product="product"
        />
      </template>
      <!--LOADING-->
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
          v-if="products.data.length"
          color="primary"
          :length="products.last_page"
          v-model="products.current_page"
          @update:model-value="page => toPage(page)"
        />

        <div v-else class="text-h6 text-grey text-center">
          Ничего не найдено
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import ProductCard from '@/Components/ProductCard.vue'
import ToolbarDropdown from '@/Components/ToolbarDropdown.vue'

import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import { useDisplay } from 'vuetify/lib/framework.mjs'

defineOptions({ layout: AppLayout })

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

const display = useDisplay()
const loading = ref(false)
const selectedTypes = ref(types.map(type => type.id))
const selectedSort = ref(sorts[0]) 
const searchText = ref()
const showUnavailable = ref(false)

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
    showUnavailable: showUnavailable.value
  }
}

function update() {
  router.get(route('products.index'), requestData(), requestOptions)
}

function toPage(pageNumber) {
  router.get(route('products.index'), {...requestData(), page: pageNumber}, requestOptions)
}

watch(selectedTypes, (oldTypes) => {
  if (oldTypes.length == 0) {
    selectedTypes.value[0] = types[0].id
  }
})

watch([selectedTypes, selectedSort, showUnavailable], update)
</script>