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
    <v-btn @click="drawer = !drawer" icon="mdi-menu"/>
  </v-app-bar>

  <v-navigation-drawer
    location="right"
    temporary
    v-model="drawer"
  >
    <v-list class="text-body-1">
      <v-list-item
        :active="$page.url === '/products'"
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
      </v-list-item>
        
      <v-list-item
        :active="$page.url.includes('/about')"
        prepend-icon="mdi-information"
      >
        О нас
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
        prepend-icon="mdi-profile"
      >
        Войти
      </v-list-item>

      <template v-if="$page.props.user?.is_admin">
        <v-divider/>

        <v-list-item
          :active="$page.url.includes('/orders')"
          @click="handleClick('orders.index')"
          prepend-icon="mdi-notebook-multiple"
        >
          Заказы
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
import { ref, defineComponent } from 'vue'
import { router } from '@inertiajs/vue3'

const drawer = ref(false)

function handleClick(url) {
  router.get(route(url))
  drawer.value = false
}
</script>
