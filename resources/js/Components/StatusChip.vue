<template>
  <v-chip
    class="text-body-1 pa-4 rounded"
    :color="statusColors[status]"
    variant="elevated"
  >
    {{ status }}
  </v-chip>
</template>

<script setup>
defineProps({ status: String })
const statusColors = {
  'В работе': 'blue-lighten-1',
  'Отправлен': 'success',
  'Отменён': 'grey-darken-3',
}
</script>