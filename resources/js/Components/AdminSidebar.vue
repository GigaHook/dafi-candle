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

      <v-list-item
        prepend-icon="mdi-plus-box"
        title="Добавить товар"
        @click="$router.get(route('products.create'))"
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

</script>

<script>
export default {
  name: 'AdminSidebar'
}
</script>

<style scoped>
</style>