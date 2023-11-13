<template>
  <div class="d-flex my-2">
    <v-btn
      icon
      size="36"
      variant="tonal"
      rounded="lg"
      color="primary"
      @click="$emit('update')"
    >
      <v-icon icon="mdi-minus"/>
    </v-btn>
    
    <div class="mx-4 mt-1" style="font-size: 18px">
      {{ quantity }}
    </div>

    <v-btn
      icon
      size="36"
      variant="tonal"
      rounded="lg"
      color="primary"
      @click="!unavailable && $emit('store')"
      :style="unavailable && 'opacity: 0.5'"
    >
      <v-icon icon="mdi-plus"/>
      <v-tooltip
        v-if="unavailable"
        open-delay="300"
        location="bottom"
        activator="parent"
        open-on-hover
      >
        Больше нет в наличии
      </v-tooltip>
    </v-btn>
  </div>
</template>

<script setup>
defineProps({ quantity: Number, unavailable: Boolean })
</script>











