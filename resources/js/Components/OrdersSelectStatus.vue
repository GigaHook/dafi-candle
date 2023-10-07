<template>
  <v-select
    variant="solo"
    color="yellow"
    density="compact"
    hide-details="auto"
    flat
    :items="Object.keys(statusColors)"
    v-model="status"
    style="width:180px !important"
    @update:model-value="updateStatus"
    :readonly="loading"
    menu-icon="mdi-chevron-down"
  >
    <template #chip="{ item }">
      <v-chip
        class="text-body-1 pa-4 rounded"
        :color="statusColors[item.raw]"
        variant="elevated"
      >
        {{ item.raw }}
      </v-chip>
    </template>
  </v-select>
</template>

<script setup>
import { useOrder } from '@/Composables/useOrder'

const { order } = defineProps({ order: Object })
const { statusColors, updateStatus, loading, status } = useOrder(order)
</script>
