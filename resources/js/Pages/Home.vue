<template>
  <v-app>
    <v-app-bar :color="`rgba(0, 0, 0, ${scroll / 150 - 0.5})`" :elevation="scroll > 150 ? 3 : 0">
      <span
        class="dafi-en me-auto ps-2" 
        style="color:white; cursor: pointer; font-size: 50px;" 
        :style="`opacity:${scroll / 150 - 0.3};min-width:234px`"
        @click="scrollTo('welcome')"
      >
        Dafi Candle
      </span>
      
      <HomeNavItem @click="scrollTo('about')">
        О нас
      </HomeNavItem>

      <HomeNavItem @click="scrollTo('candles')">
        Свечи
      </HomeNavItem>

      <HomeNavItem @click="scrollTo('flavors')">
        Ароматы
      </HomeNavItem>

      <HomeNavItem @click="scrollTo('sachet')">
        Саше&#x301;
      </HomeNavItem>

      <HomeNavItem @click="scrollTo('pricing')">
        Прайс-лист
      </HomeNavItem>

      <div class="nav-divider"></div> <!--в мобилке ломает вёрстку, сделать бургер-->

      <HomeNavItem icon>
        <v-icon icon="mdi-shopping"/>
        <v-tooltip
          activator="parent"
          location="bottom"
          open-delay="500"
        >
          Каталог
        </v-tooltip>
      </HomeNavItem>

      <HomeNavItem icon>
        <v-icon icon="mdi-cart"/>
        <v-tooltip
          activator="parent"
          location="bottom"
          open-delay="500"
        >
          Корзина
        </v-tooltip>
      </HomeNavItem>

      <HomeNavItem icon>
        <v-icon icon="mdi-account"/>
        <v-tooltip
          activator="parent"
          location="bottom"
          open-delay="500"
        >
          Профиль
        </v-tooltip>
      </HomeNavItem>

    </v-app-bar>

    <v-sheet class="block welcome text-white pt-24 px-8 position-relative" ref="welcome">
      <v-container class="d-flex justify-space-between" style="max-height:calc(100vh - 96px) !important">
        <div class="w-50 d-flex flex-column" style="height: 100vw;">
          <h1 class="text-h1 dafi-en" v-ripple="{ class: 'text-yellow'}">
            Dafi Candle
          </h1>
          <p class="text-h5">
            ОСОБЕННЫЕ СВЕЧИ ДЛЯ ТЕХ, <br>
            КТО ЦЕНИТ КАЧЕСТВО
          </p>

          <v-btn class="w-50 mt-4" size="large" color="primary">
            смотреть свечи
          </v-btn>
          <v-btn class="w-50 mt-4" size="large" color="primary" variant="outlined">
            весь каталог
          </v-btn>

          <div class="px-2 py-1 mb-4 w-75" style="margin-top: 10vh;">
            <template v-for="text in ['Ручная работа', 'Натуральные ингридиенты', 'Широкий выбор ароматов', 'Дизайн под заказ']">
              <v-icon
                icon="mdi-star-four-points"
                size="27"
                class="me-1 pb-2"
              />
              <span class="text-h5">{{ text }}</span><br>
            </template>
          </div>
        </div>

        <div style="height: 100vw; width:27vh">
          <div class="welcome-img mb-3"></div>
          <div class="welcome-img mb-3"></div>
          <div class="welcome-img"></div>
        </div>
        

      </v-container>
  
      <div class="position-absolute text-center text-h5 w-100" style="bottom: 50px;">
        <span @click="scrollTo('about')" class="interested" ref="about"> <!--stupid but works :)-->
          Интересно? Листай ниже <v-icon icon="mdi-arrow-down"/>
        </span>
      </div>

    </v-sheet>
    
    <v-row class="block about justify-center" color="primary">
      <v-col cols="12">
        <h2 style="font-size:70px" class="text-center mt-12">
          <span class="dafi-en">Dafi</span> <span class="dafi-ru">это...</span>
        </h2>
      </v-col>
      <v-col xl="8" lg="9" sm="10" xs="12" class="text-center text-h5 mb-12" style="line-height: 40px">
        Dafi-candle - это российский бренд крафтового производства
        ароматических продуктов из органического сырья.
        Каждая свеча изготавливается вручную в уютной мастерской
        с любовью к своему делу и людям. Их мягкий, ненавязчивый аромат поможет расслабиться после трудного дня, снять стресс и восстановить душевное равновесие.
      </v-col>
    </v-row>
  
    <v-sheet class="block" ref="candles">
      <v-row>
        <v-col cols="4" class="candle pa-0">
          <v-img src="eco-5.jpg">
            <template #sources>
              <source srcset="../../../public/storage/assets/images/eco/eco-5.jpg">
            </template>
          </v-img>
        </v-col>

        <v-col cols="4" class="candle pa-0">
          <v-img src="eco-5.jpg">
            <template #sources>
              <source srcset="../../../public/storage/assets/images/eco/eco-5.jpg">
            </template>
          </v-img>
        </v-col>

        <v-col cols="4" class="candle pa-0">
          <v-img src="eco-5.jpg">
            <template #sources>
              <source srcset="../../../public/storage/assets/images/eco/eco-5.jpg">
            </template>
          </v-img>
        </v-col>

      </v-row>
    </v-sheet>
  
    <v-sheet class="block" ref="flavors"> 
      <v-row>
  
        <v-col cols="4" class="">
          asd
        </v-col>
  
        <v-col cols="4" class="">
          zxc
        </v-col>
  
        <v-col cols="4" class="">
          qwe
        </v-col>
  
      </v-row>
    </v-sheet>
    
    <v-sheet class="block" ref="sachet">
  
    </v-sheet>

    <v-sheet class="block" ref="pricing">
  
    </v-sheet>

  </v-app>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import HomeNavItem from '../Components/HomeNavItem.vue'

export default {
  components: {
    Link,
    HomeNavItem,
  },

  data() {
    return {
      scroll: 0
    }
  },

  methods: {
    scrollTo(block) {
      this.$refs[block].scrollIntoView({ behavior: "smooth" })
    },
    scrollHandler() {
      this.scroll = window.scrollY
    }
  },

  mounted() {
    window.addEventListener('scroll', this.scrollHandler)
  },
  
  destroyed () {
    window.removeEventListener('scroll', this.scrollHandler)
  }

}
</script>


<style scoped>
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
.nav-divider{
  width: 2px;
  height: 50%;
  margin: 0 10px 0 10px;
  background: #fff;
  opacity: 0.85;
}
.welcome-img{
  background-position: center center;
  background-size: cover;
  background-repeat: no-repeat;
  border-radius: 50%;
  aspect-ratio: 1/1;
}
.welcome-img:nth-of-type(1){
  background-image: url('../../../public/storage/assets/images/eco/eco-5.jpg');
}
.welcome-img:nth-of-type(2){
  background-image: url('../../../public/storage/assets/images/jar/jar-6.jpg');
}
.welcome-img:nth-of-type(3){
  background-image: url('../../../public/storage/assets/images/form/form-8.jpg');
}
.interested{
  cursor: pointer;
  transition: all .15s ease-in-out;
}
.interested:hover{
  color: #FFFF33 !important;
}
.block{
  width: 100vw;
}
.block:nth-of-type(1){
  height: calc(100vh);
  background-image: linear-gradient(to left, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)), url(../../../public/storage/assets/images/main1.jpg);
  background-repeat: no-repeat;
  background-position: right bottom;
  background-size: cover;
}
.about{
  background-image: url(../../../public/storage/assets/images/main2.jpg);
  background-repeat: no-repeat;
  background-size: cover;
}
.candle{

}
.link{
  width: 33.33%;
  height: 75vh;
  transition: .2s all ease-out;
}
.link:hover{
  width: 50%;
}
.link:nth-of-type(1){
  background-color: lawngreen;
}
.link:nth-of-type(2){
  background-color: lime;
  
}
.link:nth-of-type(3){
  background-color: limegreen;
  
}
</style>