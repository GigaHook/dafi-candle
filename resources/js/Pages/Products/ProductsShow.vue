<template>
  <Head :title="product.name"/>
  <v-container>
    
    <v-row class="justify-center">
      <v-col
        cols="12"
        offset-xl="4"
        offset-lg="2"
        offset-md="1"
      >
        <h1 class="text-h4">{{ product.name }}</h1>
      </v-col>

      <v-col xl="3" lg="4" md="5" sm="6" cols="12">
        <v-img
          :src="$page.props.storage + product.image"
          style="aspect-ratio: 3 / 4;"
          class="mb-4"
        />

        <BtnPrimary class="me-4">
          Купить
        </BtnPrimary>

        <BtnPrimary class="me-4" @click="$router.get(route('products.index'))">
          Назад
        </BtnPrimary>
      </v-col>
      
      <v-col
        xl="5" lg="6" md="6" sm="6" cols="12"
      >
        <v-card class="px-4 py-2">  
          <h2 class="text-h5">Описание</h2>
          <p class="mb-4">{{ product.description }}</p>
          <p class="mb-4">
            {{ product.type.name }}
            <span v-if="product.type.name != 'Саше'">свеча</span>
          </p>
          <div
            v-for="tag in tags"
            class="d-flex align-center"
            style="white-space: nowrap;"
          >
            {{ tag.name }}
            <v-divider v-if="tag.value" class="mx-2"/>
            {{ tag.value }}
          </div>
        </v-card>
      </v-col>
      
    </v-row>
  </v-container>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue'
export default {
  layout: AppLayout,
  
  props: {
    product: Object,
    tags: Array,
  },
  data() {
    return {
      
    }
  },
}
</script>

<style scoped>
h1{
  margin: 0;
}
</style>