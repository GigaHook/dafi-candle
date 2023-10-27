import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { useOrder } from './useOrder'

export default function useProduct(product, order=null) {
  let productInstance
  let store
  let update
  let loading
  let buttonText
  let icon
  
  const page = usePage()

  if (!order) {
    buttonText = 'Купить'
    icon = 'mdi-cart-check'
    loading = ref(false)

    productInstance = computed(() => {
      return page.props.cart.items.find(item => item.id == product.id)
    })

    store = () => {
      router.post(route('cart.store'), {
        id: product.id
      }, { 
        preserveState: true,
        preserveScroll: true,
        onStart: () => loading.value = true,
        onFinish: () => loading.value = false,
      })
    }
    
    update = () => {
      router.patch(route('cart.update', {
          id: product.id 
        }), { 
        preserveState: true,
        preserveScroll: true,
        onStart: () => loading.value = true,
        onFinish: () => loading.value = false,
      })
    }
  } else {
    //TODO fix this laggy sheeet
    buttonText = 'Добавить'
    icon = 'mdi-notebook-check-outlined'

    let updateOrderItems

    ({ updateOrderItems, loading } = useOrder(order))

    productInstance = computed(() => {
      return page.props.order.products.find(item => item.id == product.id)
    })

    store = updateOrderItems('post', product.id)
    update = updateOrderItems('patch', product.id)
  }

  return {
    loading,
    store,
    update,
    productInstance,
    buttonText,
    icon,
  }
}