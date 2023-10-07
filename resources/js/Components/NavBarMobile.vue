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

    <v-app-bar-nav-icon @click="drawer = !drawer"/>

  </v-app-bar>

  <v-navigation-drawer
    location="right"
    temporary
    v-model="drawer"
  >
    <v-list class="text-body-1">
      <v-list-item
        :active="$page.url.includes('/products')"
        @click="handleClick('products.index')"
      >
        Каталог
        <template #prepend>
          <v-icon icon="mdi-shopping" class="me-3"/>
        </template>
      </v-list-item>
    
      <v-list-item
        :active="$page.url.includes('/cart')"
        @click="handleClick('cart.index')"
      >
        Корзина
        <template #prepend>
          <v-icon icon="mdi-cart" class="me-3"/>
        </template>
      </v-list-item>
        
      <v-list-item
        :active="$page.url.includes('/about')"
      >
        О нас
        <template #prepend>
          <v-icon icon="mdi-information" class="me-3"/>
        </template>
      </v-list-item>
    
      <v-list-item
        v-if="$page.props.user"
        :active="$page.url.includes('/profile')"
        @click="handleClick('profile')"
      >
        Профиль
        <template #prepend>
          <v-icon icon="mdi-account" class="me-3"/>
        </template>
      </v-list-item>
    
      <v-list-item
        v-else
        :active="$page.url.includes('/login')"
        @click="handleClick('login')"
      >
        Войти
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const drawer = ref(false)

function handleClick(url) {
  router.get(route(url))
  drawer.value = false
}
</script>
