<template>
  <v-app style="background-color: ;">

    <v-app-bar
      style="background: black;"
      elevation="3"
    >
      <span class="dafi-en me-auto ps-2"
        style="color:white; cursor: pointer; font-size: 50px; min-width:234px" 
        @click="$router.get('/')"
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
      >
        корзина
      </NavItem>
      
      <NavItem
        :active="$page.url.includes('/about')"
      >
        о нас
      </NavItem>

      <NavItem
        :active="$page.url.includes('/profile')"
        v-if="$page.props.user"
        @click="$router.get(route('profile'))"
      >
        профиль
      </NavItem>

      <NavItem
        :active="$page.url.includes('/login')"
        v-else
        @click="$router.get(route('login'))"
      >
        войти
      </NavItem>

    </v-app-bar>
    
    <div style="height: 64px"></div>
    <slot />

  </v-app>
  
</template>

<script>
import { Link } from '@inertiajs/vue3'
import NavItem from '../Components/NavItem.vue'

export default {
  components: {
    NavItem,
    Link
  },
  data() {
    return {

    }
  },
  methods: {
    
  },
  watch: {
    
  },
  mounted() {

  }
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