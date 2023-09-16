<template>
  <tr>
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
      {{ order.status }}
    </td>
    <td>
      <BtnPrimary @click="$router.post(route('orders.show', order.id))">
        Подробнее
      </BtnPrimary>
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