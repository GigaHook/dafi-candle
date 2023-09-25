<template>
  <v-list-item
    @click="$router.get(route(to))"
  >
    <template #append>
      <v-badge
        :content="badge"
        color="red"
        inline
      />
    </template>

    <template #prepend>
      <v-badge dot>
        <v-icon :icon="icon"/>
      </v-badge>
    </template>

  </v-list-item>
</template>

<script setup>

defineProps({
  to: String,
  icon: String,
  badge: Number,
})


</script>

<style scoped>

</style>