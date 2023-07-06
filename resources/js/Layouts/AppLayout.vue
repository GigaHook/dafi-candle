<template>
  <v-app>

    <v-app-bar
      style="background: black"
      elevation="3"
    >
      <span class="dafi-en me-auto ps-2"
        style="color:white; cursor: pointer; font-size: 50px; min-width:234px" 
        @click="$router.get('/')"
      >
        Dafi Candle
      </span> 

      <NavItem>
        каталог
      </NavItem>

      <NavItem>
        корзина
      </NavItem>
      
      <NavItem>
        о нас
      </NavItem>

      <NavItem v-if="$page.props.user">
        профиль
      </NavItem>

      <NavItem v-else>
        войти
      </NavItem>

    </v-app-bar>
    
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