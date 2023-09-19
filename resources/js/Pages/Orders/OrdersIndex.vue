<template>
  <Head title="Заказы"/>
  <v-container>
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
              Стоимость
            </th>
            <th>
              Статус
            </th>
            <th>
            </th>
          </tr>
        </thead>
          
        <tbody>
          <!--<OrdersTableRow
            v-for="order in orders"
            :order="order"
          />-->

          <tr v-for="order in orders">
            <td>
              {{ order.id }}
            </td>
            <td>
              {{ `${order.adress.name} ${order.adress.lastname} ${order.adress.patronymic}` }} 
            </td>
            <td>
              {{ order.price }}
              <v-icon icon="mdi-currency-rub" size="18" class="ms-n1 mb-1"/>
            </td>
            <td>
              <v-select
                variant="solo"
                color="yellow"
                density="compact"
                hide-details="auto"
                chips
                :items="['В работе', 'Отправлен', 'Отменён']"
                :model-value="order.status"
                class="ms-n4"
                style="max-width: fit-content;"
              >
                <template #chip="{ item }">
                  <v-chip
                    class="text-body-1 pa-4 rounded"
                    :color="defineChipColor(item.raw)"
                    variant="elevated"
                  >
                    {{ item.raw }}
                  </v-chip>
                </template>
              </v-select>
            </td>
            <td>
              <BtnPrimary @click="$router.post(route('orders.show', order.id))">
                Подробнее
              </BtnPrimary>
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
import { router } from '@inertiajs/vue3'
import OrdersTableRow from '@/Components/OrdersTableRow.vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({
  layout: AppLayout
})

defineComponent({
  OrdersTableRow: OrdersTableRow
})

const { orders } = defineProps({
  orders: Array
})

const defineChipColor = chip => {
  switch (chip) {
    case 'В работе':
      return 'primary'
    
    case 'Отправлен':
      return 'success'
    
    case 'Отменён':
      return 'primarygrey-lighten-2'
  }
}

</script>

<style scoped>

</style>