<template>
  <div
    class="d-flex align-center"
    style="white-space: nowrap;"
  >
    <slot name="left">{{ left }}</slot>
    <v-divider class="mx-2"/>
    <slot name="right">{{ right ?? 'Да' }}</slot>
  </div>
</template>

<script setup>
defineProps({
  left: String,
  right: {
    required: false,
    default: 'Да',
  },
})
</script>