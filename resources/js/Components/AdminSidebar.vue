<template>
  <v-navigation-drawer
    location="left"
    rail
    expand-on-hover
    permanent
  >
    <v-list>
      <v-list-item class="text-h6">
        Управление
        <template #prepend>
          <v-icon icon="mdi-cog" class="text-h5"/>
        </template>
      </v-list-item>
    </v-list>

    <v-divider/>

    <v-list nav density="compact">
      <AdminSidebarItem
        icon="mdi-plus-box"
        title="Добавить товар"
        @click="$router.get(route('products.create'))"
      />

      <AdminSidebarItem
        icon="mdi-notebook-multiple"
        title="Заказы"
        @click="$router.get(route('orders.index'))"
        :badge="Number($page.url !== '/orders' && $page.props.badges.ordersAdmin)"
      />

    </v-list>
  </v-navigation-drawer>
</template>

<script setup>
import { defineComponent, ref } from 'vue'
import AdminSidebarItem from '@/Components/AdminSidebarItem.vue'

const drawer = true

defineComponent({
  AdminSidebarItem
})

</script>

<style scoped>

</style>