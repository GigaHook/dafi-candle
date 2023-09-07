<template>
  <Head title="Заказы"/>
  <v-container fluid>
    <v-card
      class="fill-height d-flex flex-column justify-space-between px-4 pt-2 pb-3"
      elevation="3"
    >
      <h1 class="text-h4">Заказы</h1>

      <v-table density="compact" v-if="orders.length">
        <thead>
          <tr>
            <th>
              №
            </th>
            <th>
              Заказчик
            </th>
            <th>
              Адрес
            </th>
            <th>
              Стоимость
            </th>
            <th>
              Добавлен
            </th>
            <th>
              Содержание
            </th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="order in orders">
            <td>
              {{ order.id }}
            </td>
            <td>
              фыв
            </td>
            <td>
              фыв
            </td>
            <td>
              фыв
            </td>
            <td>
              фыв
            </td>
            <td>
              фыв
            </td>
          </tr>
        </tbody>
      </v-table>

      <span v-else>
        В данный момент нет заказов
      </span>

    </v-card>
  </v-container>
</template>

<script setup>
import { defineComponent } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue';

defineOptions({
  layout: AppLayout
})

const orders = defineProps({
  orders: Object
})

</script>

<style scoped>

</style>