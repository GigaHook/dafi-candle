import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

export function useOrder(order) {
  const createdAt = order.created_at.split('T')
  const creationDate = createdAt[0]
  const fullTime = createdAt[1].split('.')[0].split(':')
  const creationTime = `${fullTime[0]}:${fullTime[1]}`
  const statusColors = {
    'В работе': 'blue-lighten-1',
    'Отправлен': 'success',
    'Отменён': 'grey-darken-3',
  }

  const status = ref(order.status)
  const loading = ref(false)

  function updateStatus() {
    router.post(route('orders.status', { id: order.id }), {
      status: status.value
    }, {
      preserveState: true,
      preserveScroll: true,
      onStart: () => loading.value = true,
      onFinish: () => loading.value = false,
    })
  }

  function updateOrderItems(method, productId) {
    router.post(route('orderitems.store', [order.id, productId]), {
      _method: method
    }, {
      preserveState: true,
      preserveScroll: true,
      onStart: () => loading.value = true,
      onFinish: () => loading.value = false,
    })
  }

  return {
    creationDate,
    creationTime,
    statusColors,
    status,
    loading,
    updateStatus,
    updateOrderItems,
  }
}