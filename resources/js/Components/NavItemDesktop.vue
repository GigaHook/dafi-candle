<template>
  <v-btn
    variant="plain"
    size="large"
    color="white"
    class="button"
    :class="{ 'active': active }"
    v-ripple="{ class: 'text-yellow'}"
  >
    <slot/>

    <template #append>
      <v-badge
        v-if="badge"
        :content="badge"
        max="9"
        floating
        color="red"
      />
    </template>

  </v-btn>
</template>

<script setup>
defineProps({ active: Boolean, badge: Number, })
</script>

<style scoped>
.button{
  opacity: 1;
  transition: all .1s ease-in-out;
}
.button:hover{
  color: #FFFF33 !important;
}
.active{
  color: #FFFF33 !important;
}
</style>