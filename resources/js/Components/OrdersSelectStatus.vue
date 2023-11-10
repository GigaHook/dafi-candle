<template>
  <v-select
    variant="solo"
    color="yellow"
    density="compact"
    hide-details="auto"
    flat
    :items="statuses"
    v-model="status"
    style="width:180px !important"
    @update:model-value="updateStatus"
    :readonly="loading"
    menu-icon="mdi-chevron-down"
  >
    <template #chip="{ item }">
      <StatusChip :status="item.raw"/>
    </template>
  </v-select>
</template>

<script setup>
import StatusChip from '@/Components/StatusChip.vue'
import { useOrder } from '@/Composables/useOrder'
import { defineComponent } from 'vue'

defineComponent({ StatusChip })
const { order } = defineProps({ order: Object })
const { updateStatus, loading, status } = useOrder(order)
const statuses = ['В работе', 'Отправлен', 'Отменён']
</script>
