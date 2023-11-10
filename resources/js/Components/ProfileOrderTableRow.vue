<template>
  <tr>
    <th>
      {{ creationDate }} <br>
      {{ creationTime }}
    </th>

    <th>
      {{ order.price }}
      <v-icon icon="mdi-currency-rub" size="18" class="ms-n1 mb-1"/>
    </th>

    <th>
      <v-chip
        class="text-body-1 pa-4 rounded"
        :color="statusColors[order.status]"
        variant="elevated"
      >
        {{ order.status }}
      </v-chip>
    </th>

    <th>
      <BtnSecondary
        @click="$inertia.get(route('orders.show', order.id))"
        class="text-button"
      >
        Подробнее
      </BtnSecondary>
    </th>

    <th>
      <BtnSecondary
        v-if="order.status == 'В работе'"
        class="text-button"
      >
        <Modal
          @confirm="updateStatus('Отменён')"
          title="Подтверждение"
          text="Вы действительно хотите отменить заказ?"
        />
        Отменить
      </BtnSecondary>
    </th>
  </tr>
</template>

<script setup>
import { useOrder } from '@/Composables/useOrder'
const props = defineProps({ order: Object })
const { creationDate, creationTime, updateStatus } = useOrder(props.order)
const statusColors = 
{
  'В работе': 'blue-lighten-1',
  'Отправлен': 'success',
  'Отменён': 'grey-darken-3',
}
</script>