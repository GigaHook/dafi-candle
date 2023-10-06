<template>
  <v-list-item>

    <template #append v-if="badge">
      <v-badge :content="badge" color="red" inline/>
    </template>

    <template #prepend>
      <v-badge v-if="badge" dot color="red">
        <v-icon :icon="icon"/>
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
