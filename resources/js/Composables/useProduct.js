import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

export default function useProduct(product) {
  const page = usePage()
  const loading = ref(false)
  const getStoredProduct = () => page.props.cart.items.find(item => item.id == product.id)
  const storedProduct = computed(getStoredProduct)
  const quantity = computed(() => storedProduct.value.quantity)
  const isAvailable = computed(() => quantity.value < product.available && product.available)

  function store() {
    router.post(route('cart.store'), {
      id: product.id
    }, { 
      preserveState: true,
      preserveScroll: true,
      onStart: () => loading.value = true,
      onFinish: () => loading.value = false,
    })
  }
  
  function update() {
    router.patch(route('cart.update', product.id), { 
      preserveState: true,
      preserveScroll: true,
      onStart: () => loading.value = true,
      onFinish: () => loading.value = false,
    })
  }

  return {
    storedProduct,
    loading,
    store,
    update,
    quantity,
    isAvailable,
  }
}