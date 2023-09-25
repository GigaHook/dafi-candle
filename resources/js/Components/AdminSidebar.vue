<template>
  <v-navigation-drawer location="left" expand-on-hover rail>
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
        badge="3"
      />

      <v-list-item
        prepend-icon="mdi-notebook-multiple"
        title="Заказы"
        @click="$router.get(route('orders.index'))"
      />

      <v-list-item
        prepend-icon="mdi-notebook-plus"
        title="Создать заказ"
        @click="$router.get(route('orders.create'))"
      />

    </v-list>
  </v-navigation-drawer>
</template>

<script setup>
import { defineComponent } from 'vue';
import AdminSidebarItem from './AdminSidebarItem.vue'

defineComponent({
  AdminSidebarItem
})

</script>

<script>
export default {
  name: 'AdminSidebar'
}
</script>

<style scoped>
</style>