<template>
  <v-app>
    <v-layout>
      
      <NavBar/>

      <AdminSidebar v-if="$page.props.user?.is_admin"/>

      <v-main>
        <slot />
      </v-main>
      
    </v-layout>
  </v-app>
</template>

<script setup>
import AdminSidebar from '@/Components/AdminSidebar.vue'
import NavBar from '@/Components/NavBar.vue'

import { defineComponent } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import { useToast, TYPE } from 'vue-toastification'

defineComponent({
  NavBar,
  AdminSidebar,
})

const page = usePage()
const toast = useToast()

router.on('finish', () => {
  if (page.props.toast) {
    toast(page.props.toast.text, {
      timeout: 3000,
      type: TYPE[page.props.toast.type],
      toastClassName: 'main-toast',
      bodyClassName: ['main-toast'],
      hideProgressBar: true,
    })
  }
})
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
.dafi-ru {
  font-family: "pehlevi" !important;
}
.title {
  font-size: 50px;
  font-family: "qirania";
}
.Vue-Toastification__toast.main-toast {
  background-color: rgb(var(--v-theme-surface));
  border-left: 4px solid rgb(var(--v-theme-primary));
}
.Vue-Toastification__toast.main-toast .Vue-Toastification__icon {
  color: rgb(var(--v-theme-primary));
}

</style>