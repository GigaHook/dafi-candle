<template>
  <v-app-bar elevation="3">
    <span
      class="dafi-en me-auto ps-2"
      style="color:white; cursor: pointer; font-size: 50px; min-width:234px"
      @click="$router.get(route('home'))"
    >
      Dafi Candle
    </span>

    <NavItem
      :active="$page.url.includes('/products')"
      @click="$router.get(route('products.index'))"
    >
      каталог
    </NavItem>

    <NavItem
      :badge="$page.props.badges.cart"
      :active="$page.url.includes('/cart')"
      @click="$router.get(route('cart.index'))"
    >
      корзина
    </NavItem>
      
    <NavItem
      :active="$page.url.includes('/about')"
    >
      о нас
    </NavItem>

    <NavItem
      v-if="$page.props.user"
      :active="$page.url.includes('/profile')"
      @click="$router.get(route('profile'))"
    >
      профиль
    </NavItem>

    <NavItem
      v-else
      :active="$page.url.includes('/login')"
      @click="$router.get(route('login'))"
    >
      войти
    </NavItem>
  </v-app-bar>
</template>

<script setup>
import NavItem from './NavItem.vue'
import { defineComponent } from 'vue'


defineComponent({
  NavItem,
})
</script>

<style scoped>

</style>