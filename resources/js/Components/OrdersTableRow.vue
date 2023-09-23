<template>
  <tr>

    <td>{{ order.id }}</td>
    
    <td>
      {{ `${order.adress.name} ${order.adress.lastname} ${order.adress.patronymic}` }}
    </td>

    <td>
      {{ order.created_at.split('T')[0] }} <br>
      {{ order.created_at.split('T')[1].split('.')[0] }}
    </td>
    
    <td>
      {{ order.price }} <v-icon icon="mdi-currency-rub" size="18" class="ms-n1 mb-1"/>
    </td>

    <td>
      <v-select
        variant="solo"
        color="yellow"
        density="compact"
        hide-details="auto"
        flat
        :items="['В работе', 'Отправлен', 'Отменён']"
        v-model="status"
        class="ms-n4"
        style="width:180px !important"
        @update:model-value="updateStatus"
        :loading="loading"
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
      <BtnSecondary
        @click="$router.get(route('orders.show', order.id))"
        class="text-button"
      >
        Подробнее
      </BtnSecondary>
    </td>

  </tr>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const { order } = defineProps({
  order: Object
})

const status = ref(order.status)
const loading = ref(false)

function updateStatus() {
  router.post(route('orders.status', { id: order.id }), {
    status: status.value
  }, {
    preserveState: true,
    preserveScroll: true,
    processing: loading.value
  })
}

function defineChipColor(chip) {
  switch (chip) {
    case 'В работе':
      return 'blue-lighten-1'
    
    case 'Отправлен':
      return 'success'

    default:
      return 'grey-darken-3'
  }
}

</script>

<style scoped>

</style>