<template>
  <tr>
    <td>
      {{ order.id }}
    </td>
    
    <td>
      {{ `${order.adress.name} ${order.adress.lastname} ${order.adress.patronymic}` }}
    </td>

    <td>
      {{ creationDate }}<br>
      {{ creationTime }}
    </td>

    <td>
      {{ order.price }} 
      <v-icon icon="mdi-currency-rub" size="18" class="ms-n1 mb-1"/>
    </td>

    <td>
      <OrdersSelectStatus :order="order" class="ms-n4"/>
    </td>

    <td>
      <v-chip v-once :style="{ 'opacity': order.viewed_admin ? 0 : 1 }">
        Новый
      </v-chip>
    </td>

    <td class="px-0">
      <BtnSecondary
        @click="$inertia.get(route('orders.show', order.id))"
        class="text-button"
      >
        Подробнее
      </BtnSecondary>
    </td>

    <td class="px-0">
      <v-btn
        variant="plain"
        icon
      >
        <v-icon icon="mdi-delete-outline"/>
        <Modal
          @confirm="$inertia.delete(route('orders.destroy', order.id))"
          title="Подтверждение"
          :text="`Удалить заказ №${order.id}?`"
        />
      </v-btn>
    </td>
  </tr>
</template>

<script setup>
import OrdersSelectStatus from './OrdersSelectStatus.vue'
import { defineComponent } from 'vue'
import { useOrder } from '@/Composables/useOrder'

defineComponent({ OrdersSelectStatus })

const { order } = defineProps({ order: Object })
const { creationDate, creationTime } = useOrder(order)
</script>