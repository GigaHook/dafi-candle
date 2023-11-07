import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'

export function useOrder(order) {
  const createdAt = computed(() => (new Date(order.created_at)).toLocaleString("ru-RU").split(', '))
  const creationDate = createdAt.value[0]
  const creationTime = createdAt.value[1]
  const status = ref(order.status)
  const loading = ref(false)

  function updateStatus(argStatus=null) {
    router.post(route('orders.status', { id: order.id }), {
      status: argStatus ?? status.value
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
    status,
    loading,
    updateStatus,
    updateOrderItems,
  }
}
