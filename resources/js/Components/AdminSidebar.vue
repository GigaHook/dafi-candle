<template>
  <v-navigation-drawer
    location="left"
    elevation="3"
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

    <v-list nav>
      <AdminSidebarItem
        icon="mdi-plus-box"
        title="Добавить товар"
        @click="$inertia.get(route('products.create'))"
      />

      <AdminSidebarItem
        icon="mdi-notebook-multiple"
        title="Заказы"
        @click="$inertia.get(route('orders.index'))"
        :badge="Number($page.url !== '/orders' && $page.props.badges.ordersAdmin)"
      />
    </v-list>
  </v-navigation-drawer>
</template>

<script setup>
import AdminSidebarItem from '@/Components/AdminSidebarItem.vue'
import { defineComponent } from 'vue'
import { useDisplay } from 'vuetify/lib/framework.mjs'

defineComponent({ AdminSidebarItem })
</script>