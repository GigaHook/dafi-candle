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
            <th>№</th>
            <th>Заказчик</th>
            <th>Дата</th>
            <th>Стоимость</th>
            <th>Статус</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
          
        <tbody>
          <OrdersTableRow
            v-for="order in orders"
            :order="order"
          />
        </tbody>
      </v-table>

      <span v-else>
        В данный момент нет заказов
      </span>

    </v-card>
  </v-container>
</template>

<script setup>
import { defineComponent, onMounted } from 'vue'
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

onMounted(() => {
  router.post(route('orders.removeBadges'), {
    preserveState: true,
    preserveScroll: true,
  })
})

</script>

<style scoped>

</style>