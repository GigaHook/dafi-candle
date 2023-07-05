<template>
  <v-app>

    <v-app-bar
      :style="{ background: navColor}"
      :elevation="scroll > 40 ? 5 : 0"
      class="px-6 pt-2"
    >
    {{ $refs['candles'] }}
      <Link
        href="/" 
        class="title me-auto"
        :style="{ color: $page.url === '/' ? logoColor : 'white' }"
        :disabled="scroll < 40"
      >
        Dafi Candle
      </Link>
      <v-btn
        variant="plain"
        style="opacity: 1 !important; color: white;"
        @click="scrollTo('candles')"
      >
        свечи
      </v-btn>
      <v-btn
        variant="plain"
        style="opacity: 1 !important; color: white;"
      >
        ароматы
      </v-btn>
      <v-btn
        variant="plain"
        style="opacity: 1 !important; color: white;"
      >
        саше
      </v-btn>
      <NavItem to="/catalog">Каталог</NavItem>
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
      scroll: 0,
      navColor: 'none',
      logoColor: 'black',
    }
  },
  methods: {
    scrollHandler() {
      this.scroll = window.scrollY
      this.navColor = `rgba(0, 0, 0, ${this.scroll / 64})`
      this.logoColor = `rgba(255, 255, 255, ${this.scroll / 200})`
    },
  },
  watch: {
    '$page.url'(newValue) {
      if (newValue === '/')
      window.addEventListener('scroll', this.scrollHandler())
      else window.removeEventListener('scroll', this.scrollHandler())
    }
  },
  mounted() {
    if (this.$page.url === '/')
    window.addEventListener('scroll', this.scrollHandler)
  }
}

</script>

<style scoped>
@font-face {
  font-family: "qirania";
  src: url(../../../public/storage/assets/font/qirania.ttf);
}
.title {
  font-size: 50px;
  font-family: "qirania";
}
</style>