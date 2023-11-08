<template>
  <v-btn
    icon
    color="grey"
    variant="outlined"
    class="ms-2"
    rounded
  >
    <v-icon :icon="icon" color="grey-lighten-1"/>
    <v-menu
      activator="parent"
      transition="slide-y-transition"
      :close-on-content-click="false"
    >
      <slot></slot>
    </v-menu>
  </v-btn>
</template>

<script setup>
defineProps({ icon: String })
</script>