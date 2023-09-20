<template>
  <tr v-for="order in orders">
    <td>{{ order.id }}</td>
    <td>{{ `${order.adress.name} ${order.adress.lastname} ${order.adress.patronymic}` }}</td>
    <td>{{ order.price }}<v-icon icon="mdi-currency-rub" size="18" class="ms-n1 mb-1"/></td>

    <td>
      <v-select
        variant="solo"
        color="yellow"
        density="compact"
        hide-details="auto"
        chips
        flat
        :items="['В работе', 'Отправлен', 'Отменён']"
        :model-value="order.status"
        class="ms-n4"
        style="width:180px !important"
        @update:model-value="updateStatus"
      >
      <!--вот тут остановился-->
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
        @click="$router.post(route('orders.show', order.id))"
        class="text-button"
      >
        Подробнее
      </BtnSecondary>
    </td>

  </tr>
</template>

<script setup>

const { order } = defineProps({
  order: Object
})
</script>

<style scoped>

</style>