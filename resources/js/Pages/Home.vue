<template>
  <Head title=""/>
  <v-app>
    <v-app-bar
      :color="`rgba(0, 0, 0, ${scroll / 150 - 0.5})`"
      :elevation="scroll > 150 ? 3 : 0"
    >
      <span
        class="dafi-en me-auto ps-2" 
        style="color:white; cursor: pointer; font-size: 50px; min-width: 234px;" 
        :style="`opacity:${scroll / 150 - 0.3};`"
        @click="scrollTo('welcome')"
        v-ripple="false"
      >
        Dafi Candle
      </span>
      
      <NavItemDesktop @click="scrollTo('about')">
        О нас
      </NavItemDesktop>

      <NavItemDesktop @click="scrollTo('candles')">
        Свечи
      </NavItemDesktop>

      <NavItemDesktop @click="scrollTo('flavors')">
        Ароматы
      </NavItemDesktop>

      <NavItemDesktop @click="scrollTo('sachet')">
        Саше&#x301;
      </NavItemDesktop>

      <NavItemDesktop @click="scrollTo('pricing')">
        Прайс-лист
      </NavItemDesktop>

      <div class="nav-divider"></div> 

      <NavItemDesktop @click="$inertia.get(route('products.index'))" icon>
        <v-icon icon="mdi-shopping"/>
        <v-tooltip
          activator="parent"
          location="bottom"
          open-delay="500"
        >
          Каталог
        </v-tooltip>
      </NavItemDesktop>

      <NavItemDesktop @click="$inertia.get(route('cart.index'))" icon>
        <v-icon icon="mdi-cart"/>
        <v-tooltip
          activator="parent"
          location="bottom"
          open-delay="500"
        >
          Корзина
        </v-tooltip>
      </NavItemDesktop>

      <NavItemDesktop
        v-if="!!$page.props.user"
        @click="$inertia.get('/profile')"
        icon
      >
        <v-icon icon="mdi-account"/>
        <v-tooltip
          activator="parent"
          location="bottom"
          open-delay="500"
        >
          Профиль
        </v-tooltip>
      </NavItemDesktop>

      <NavItemDesktop
        v-else
        @click="$inertia.get('/login')"
        icon
      >
      <v-icon icon="mdi-account"/>
        <v-tooltip
          activator="parent"
          location="bottom"
          open-delay="500"
        >
          Войти
        </v-tooltip>
      </NavItemDesktop>

    </v-app-bar>

    <v-sheet class="block text-white pt-24 px-8 position-relative">
      <div class="welcome position-absolute"></div>
      <v-row class="justify-space-between">

        <v-col xs="11" md="8" lg="7" xl="6">
          <div class="d-flex flex-column" style="height: 100vw;">
            <h1 class="text-h1 dafi-en">
              Dafi Candle
            </h1>
            <p class="text-button" style="font-size: 20px !important;">
              ОСОБЕННЫЕ СВЕЧИ ДЛЯ ТЕХ, <br>
              КТО ЦЕНИТ КАЧЕСТВО
            </p>
          
            <!--кнопки-->
            <v-btn class="w-50 mt-4" size="large" color="primary">
              смотреть свечи
            </v-btn>
            <v-btn class="w-50 mt-4" size="large" color="primary" variant="outlined">
              весь каталог
            </v-btn>
          
            <!--список-->
            <div class="px-2 py-1 my-4 w-75">
              <template v-for="text in [
                'Ручная работа',
                'Натуральный воск', 
                'Дизайн под заказ',
                'Премиальные ароматы',
                'Идеальный подарок',
              ]">
                <v-icon
                  icon="mdi-star-four-points"
                  size="27"
                  class="me-1 pb-2"
                />
                <span class="text-h5">{{ text }}</span><br>
              </template>
            </div>
          </div>
        </v-col>
        
        <v-col xs="11" md="4" xl="3">
          <v-hover v-slot="{ isHovering, props }">
            <v-img
              class="welcome-img mb-7 ms-24"
              height="260px"
              width="260px"
              v-bind="props"
              src="img"
              cover
              aspect-ratio="1/1"
            >
              <template #sources>
                <source srcset="../../../public/storage/assets/images/eco/eco-8.jpg">
              </template>
              <v-overlay
                :model-value="isHovering"
                contained
                class="d-flex justify-center align-center"
              >
                <div class="text-h4 text-center">
                  Ботанические
                </div>
              </v-overlay>
            </v-img>
          </v-hover>
        </v-col>


          <!--<v-col cols="3" class="mt-n8">
            <v-hover v-slot="{ isHovering, props }">
              <v-img
                class="welcome-img mb-7 ms-24"
                v-bind="props"
                src="img"
                cover 
                style="max-height:28vh;"
              >
                <template #sources>
                  <source srcset="../../../public/storage/assets/images/eco/eco-8.jpg">
                </template>
                <v-overlay
                  :model-value="isHovering"
                  contained
                  class="d-flex justify-center align-center"
                >
                  <div class="text-h4 text-center">
                    Ботанические
                  </div>
                </v-overlay>
              </v-img>
            </v-hover>
          
            <v-hover v-slot="{ isHovering, props }">
              <v-img
                class="welcome-img mb-7 ms-24"
                v-bind="props"
                src="img"
                cover 
                style="max-height:28vh;"
              >
                <template #sources>
                  <source srcset="../../../public/storage/assets/images/jar/jar-10.jpg">
                </template>
                <v-overlay
                  :model-value="isHovering"
                  contained
                  class="d-flex justify-center align-center"
                >
                  <div class="text-h4 text-center">
                    В контейнере
                  </div>
                </v-overlay>
              </v-img>
            </v-hover>
          
            <v-hover v-slot="{ isHovering, props }">
              <v-img
                class="welcome-img mb-7 ms-24"
                v-bind="props"
                src="img"
                cover 
                style="max-height:27vh"
              >
                <template #sources>
                  <source srcset="../../../public/storage/assets/images/form/form-9.jpg">
                </template>
                <v-overlay
                  :model-value="isHovering"
                  contained
                  class="d-flex justify-center align-center"
                >
                  <div class="text-h4 text-center">
                    Формовые
                  </div>
                </v-overlay>
              </v-img>
            </v-hover>

          </v-col>-->
      </v-row>
      
      
      <!--круглежки-->
      <!--<div style="height: 100vw; width:27vh" class="mt-n8">
        
      </div>-->
  
      <div class="position-absolute text-center text-h5 w-100" style="bottom: 50px;">
        <b ref="about"></b>
        <BtnSecondary @click="scrollTo('about')" size="large">
          Интересно? Листай ниже <v-icon icon="mdi-arrow-down"/>
        </BtnSecondary>
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
  
    <v-sheet class="block my-3">
      <b ref="candles"></b>
      <v-row>
        
        <v-col cols="4" class="candle px-0 mt-n1" style="max-height:77vh;">
          <v-img src="img" cover>
            <template #sources>
              <source srcset="../../../public/storage/assets/images/eco/eco-6.jpg">
            </template>
          </v-img>
        </v-col>

        <v-col cols="4" class="candle px-0 mt-n1" style="max-height:77vh;">
          <v-img src="eco-5.jpg" cover>
            <template #sources>
              <source srcset="../../../public/storage/assets/images/form/form-10.jpg">
            </template>
          </v-img>
        </v-col>

        <v-col cols="4" class="candle px-0 mt-n1" style="max-height:77vh;">
          <v-img src="eco-5.jpg" cover>
            <template #sources>
              <source srcset="../../../public/storage/assets/images/jar/jar-7.jpg">
            </template>
          </v-img>
        </v-col>

      </v-row>
    </v-sheet>
  
    <v-sheet class="block"> 
      <b ref="flavors"></b>
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
import { Link, Head } from '@inertiajs/vue3'
import NavItemDesktop from '../Components/NavItemDesktop.vue'

export default {
  components: {
    Link,
    Head,
    NavItemDesktop,
  },

  data() {
    return {
      scroll: 0
    }
  },

  methods: {
    scrollTo(block) {
      window.scrollTo(this.$refs[block].$el)
    },
    scrollHandler() {
      this.scroll = window.scrollY
    },
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
  border-radius: 50%;
  cursor: pointer;
  overflow: hidden;
}
/*.welcome-img:nth-of-type(1){
  background-image: url('../../../public/storage/assets/images/eco/eco-8.jpg');
}
.welcome-img:nth-of-type(2){
  background-image: url('../../../public/storage/assets/images/jar/jar-10.jpg');
}
.welcome-img:nth-of-type(3){
  background-image: url('../../../public/storage/assets/images/form/form-9.jpg');
}*/
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