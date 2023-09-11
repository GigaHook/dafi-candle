<template>
  <Head title="Заказы"/>
  <v-container fluid>
    <v-card
      class="fill-height d-flex flex-column justify-space-between px-4 pt-2 pb-3"
      elevation="3"
    >
      <h1 class="text-h5">Заказы</h1>
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
              Доставка
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
              Статус
            </th>
            <th>
            </th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="order in orders">
            <td>
              {{ order.id }}
            </td>
            <td>
              {{ `${order.adress.name} ${order.adress.lastname} ${order.adress.patronymic}` }} 
            </td>
            <td>
              {{ order.adress.type }}
            </td>
            <td>
              {{ order.adress.city }},
              {{ order.adress.street }},
              {{ order.adress.house_number }},
              {{ order.adress.flat_number ? order.adress.flat_number + ',' : '' }}
              {{ order.adress.postal_code ? "почтовый индекс " + order.adress.postal_code + ',' : '' }}
            </td>
            <td>
              {{ order.price }}
              <v-icon icon="mdi-currency-rub" size="18" class="ms-n1 mb-1"/>
            </td>
            <td>
              {{ order.created_at }}
            </td>
            <td>
              {{ order.status }}
            </td>
            <td>
              <BtnPrimary>Подробнее</BtnPrimary>
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

const { orders } = defineProps({
  orders: Array
})

console.log(orders)

</script>

<style scoped>

</style>