<template>
  <Head title="Заказы"/>
  <v-container fluid>
    <v-row justify="center">
      <v-col cols="12" lg="10">
        <v-card
          class="fill-height d-flex flex-column justify-space-between px-4 pt-2 pb-3"
          elevation="3"
        >
          <h1 class="text-h5">Заказы</h1>
          <v-table density="compact" v-if="orders.length">
            <thead>
              <tr>
                <th>№</th>
                <th>Заказчик</th>
                <th>Дата</th>
                <th>Стоимость</th>
                <th>Статус</th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              <v-slide-x-transition group>
                <OrdersTableRow
                  v-for="order in orders"
                  :order="order"
                  :key="order.id"
                />
              </v-slide-x-transition>
            </tbody>
          </v-table>
        
          <span v-else>
            В данный момент нет заказов
          </span>
        
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import OrdersTableRow from '@/Components/OrdersTableRow.vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })
defineProps({ orders: Array })
</script>
