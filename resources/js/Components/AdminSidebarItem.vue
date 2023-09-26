<template>
  <v-list-item>
    <template #append v-if="badge">
      <v-badge :content="badge" color="red" inline/>
    </template>

    <template #prepend>
      <v-badge v-if="badge" dot color="red" class="me-8">
        <v-icon :icon="icon" color="grey-lighten-2"/>
      </v-badge>

      <v-icon :icon="icon" v-else/>
    </template>

  </v-list-item>
</template>

<script setup>

defineProps({
  icon: String,
  badge: Number,
})

</script>

<style scoped>

</style>