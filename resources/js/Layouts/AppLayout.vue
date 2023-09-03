<template>
  <v-app>
    <v-layout>
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

      <AdminSidebar v-if="$page.props.user?.is_admin"/>

      <v-main>
        <slot />
      </v-main>

      <SnackbarList/>

      <v-snackbar
        timeout="4000"
      >
        asdzxc
        <v-btn>
          asd
        </v-btn>
      </v-snackbar>

    </v-layout>
  </v-app>
</template>

<script setup>
import { ref } from 'vue'

const asd = ref(true)
</script>

<script>
import NavItem from '@/Components/NavItem.vue'
import AdminSidebar from '@/Components/AdminSidebar.vue'
import SnackbarList from '@/Components/SnackbarList.vue'

export default {
  components: {
    NavItem,
    AdminSidebar,
    SnackbarList,
  },
}

</script>

<style>
@font-face {
  font-family: "qirania";
  src: url(../../../public/storage/assets/font/qirania.ttf);
}
@font-face {
  font-family: "pehlevi";
  src: url(../../../public/storage/assets/font/pehlevi.ttf);
}
.dafi-en {
  font-family: "qirania" !important;
}
.dafi-ru{
  font-family: "pehlevi" !important;
}
.title {
  font-size: 50px;
  font-family: "qirania";
}
</style>