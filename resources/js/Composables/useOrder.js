import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'

export function useOrder(order) {
  const createdAt = order.created_at.split('T')
  const creationDate = computed(() => createdAt[0])
  const fullTime = computed(() => createdAt[1].split('.')[0].split(':'))
  const creationTime = computed(() => `${fullTime.value[0]}:${fullTime.value[1]}`)
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
    status,
    loading,
    updateStatus,
    updateOrderItems,
  }
}
