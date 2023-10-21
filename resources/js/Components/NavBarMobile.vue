<template>
  <v-app-bar elevation="3">
    <span
      class="dafi-en me-auto ps-2"
      style="color:white; cursor: pointer; font-size: 40px; min-width:234px"
      @click="handleClick('home')"
    >
      Dafi Candle
    </span>

    <v-spacer/>

    <!--TODO: добавить уведомления пользователя-->
    <v-btn @click="drawer = !drawer" icon>
      <v-badge
        v-if="badges"
        dot
        color="red"
      >
        <v-icon icon="mdi-menu"/>
      </v-badge>

      <v-icon v-else icon="mdi-menu"/>
    </v-btn>
  </v-app-bar>

  <v-navigation-drawer
    location="right"
    temporary
    v-model="drawer"
  >
    <v-list class="text-body-1">
      <v-list-item
        :active="$page.url == '/products'"
        @click="handleClick('products.index')"
        prepend-icon="mdi-shopping"
      >
        Каталог
      </v-list-item>
    
      <v-list-item
        :active="$page.url.includes('/cart')"
        @click="handleClick('cart.index')"
        prepend-icon="mdi-cart"
      >
        Корзина
        <template #append>
          <v-badge
            v-if="cartBadges"
            inline
            color="red"
            :content="cartBadges"
          />
        </template>
      </v-list-item>
    
      <v-list-item
        v-if="$page.props.user"
        :active="$page.url.includes('/profile')"
        @click="handleClick('profile')"
        prepend-icon="mdi-account" 
      >
        Профиль
      </v-list-item>
    
      <v-list-item
        v-else
        :active="$page.url.includes('/login')"
        @click="handleClick('login')"
        prepend-icon="mdi-account"
      >
        Войти
      </v-list-item>

      <v-list-item
        :active="$page.url.includes('/about')"
        @click="$router.get(route('about'))"
        prepend-icon="mdi-information"
      >
        О нас
      </v-list-item>

      <template v-if="$page.props.user?.is_admin">
        <v-divider/>

        <v-list-item
          :active="$page.url.includes('/orders')"
          @click="handleClick('orders.index')"
          prepend-icon="mdi-notebook-multiple"
        >
          Заказы
          <template #append>
            <v-badge
              v-if="$page.url !== '/orders' && $page.props.badges.ordersAdmin"
              inline
              color="red"
              :content="$page.props.badges.ordersAdmin"
            />
          </template>
        </v-list-item>

        <v-list-item
          :active="$page.url.includes('/products/create')"
          @click="handleClick('products.create')"
          prepend-icon="mdi-plus-box"
        >
          Добавить товар
        </v-list-item>
      </template>

    </v-list>
  </v-navigation-drawer>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const drawer = ref(false)
const page = usePage()

const cartBadges = computed(() => page.props.cart.items.reduce((sum, item) => sum + item.quantity, 0))
const badges = computed(() => cartBadges.value || (page.props.badges?.ordersAdmin && page.url !== '/orders'))

function handleClick(url) {
  router.get(route(url))
  drawer.value = false
}
</script>
