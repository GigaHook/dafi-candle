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
          :src="`../storage/upload/${product.image}`"
          style="aspect-ratio: 3 / 4;"
          class="mb-4 rounded"
          cover
        />

        <div class="d-flex justify-space-between w-100">
          <BtnPrimary @click="$router.post(route('cart.store'), { id: product.id })">
            Купить
          </BtnPrimary>

          <BtnSecondary @click="window.history.back()">
            Назад
          </BtnSecondary>
        </div>
      </v-col>
      
      <v-col xl="5" lg="6" md="6" sm="6" cols="12">
        <v-card class="px-4 py-2">  
          <h2 class="text-h5">Описание</h2>
          {{ product.description }} <br><br>
          {{ product.type.name }}
          <span v-if="product.type.name != 'Саше'">свеча</span><br><br>
          <ListRow
            v-for="tag in tags"
            :left="tag.name"
            :right="tag.value"
          />
        </v-card>
      </v-col>

    </v-row>
  </v-container>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import ListRow from '@/Components/ListRow.vue'
import { defineComponent } from 'vue'

defineOptions({ layout: AppLayout })
defineProps({ product: Object, tags: Array })
defineComponent({ ListRow })
</script>
