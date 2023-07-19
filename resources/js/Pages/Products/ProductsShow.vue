<template>
  <Head :title="product.name"/>
    <v-container>
      
      <v-row>
        <v-col cols=12><h1 class="text-h3">{{ product.name }}</h1></v-col>
        <v-col xl="3" lg="4" md="5" sm="6" cols="12">
          <v-img :src="$page.props.storage + product.image"/>
        </v-col>
        
        <v-col xl="6" lg="5" md="6" sm="6" cols="12">
          <h2 class="text-h5">Описание</h2>
          {{ product.description }}
          <div
            v-for="tag in tags"
            class="d-flex align-center"
          >
            {{ tag.name }}
            <v-divider class="mx-2"/>
            {{ tag.value }}
          </div>
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

</style>