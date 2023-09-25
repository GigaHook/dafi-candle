<template>
  <v-list-item>
    <template #append v-if="badge">
      <v-badge
        :content="badge"
        color="red"
        inline
      />
    </template>

    <template #prepend>
      <v-badge
        dot
        color="red" 
        v-if="badge" 
        class="me-8"
      >
        <v-icon :icon="icon" color="grey"/>
      </v-badge>

      <v-icon :icon="icon" v-else/>
    </template>

  </v-list-item>
</template>

<script setup>

defineProps({
  icon: String,
  badge: String,
})


</script>

<style scoped>

</style>