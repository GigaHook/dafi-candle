<template>
  <v-app-bar elevation="3">
    <span
      class="dafi-en me-auto ps-2"
      style="color:white; cursor: pointer; font-size: 50px; min-width:234px"
      @click="$inertia.get(route('home'))"
    >
      Dafi Candle
    </span>

    <NavItemDesktop
      :active="$page.url.includes('/products')"
      @click="$inertia.get(route('products.index'))"
      text="asd"
    >
      каталог
    </NavItemDesktop>

    <NavItemDesktop
      :active="$page.url.includes('/cart')"
      :badge="getCartBadge()"
      @click="$inertia.get(route('cart.index'))"
    >
      корзина
    </NavItemDesktop>
      
    <NavItemDesktop
      :active="$page.url.includes('/about')"
      @click="$inertia.get(route('about'))"
    >
      о нас
    </NavItemDesktop>

    <NavItemDesktop
      v-if="$page.props.user"
      :active="$page.url.includes('/profile')"
      @click="$inertia.get(route('profile'))"
    >
      профиль
    </NavItemDesktop>

    <NavItemDesktop
      v-else
      :active="$page.url.includes('/login')"
      @click="$inertia.get(route('login'))"
    >
      войти
    </NavItemDesktop>
  </v-app-bar>
</template>

<script setup>
import NavItemDesktop from './NavItemDesktop.vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

function getCartBadge() {
  let badges = 0
  page.props.cart.items.forEach(item => badges += item.quantity)
  return badges
}
</script>