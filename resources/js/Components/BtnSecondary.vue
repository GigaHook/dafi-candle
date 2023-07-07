<template>
  <v-btn
    variant="plain"
    color="white"
    class="button"
    v-ripple="{ class: 'text-yellow'}"
  >
    <slot/>
  </v-btn>
</template>

<style scoped>
.button{
  opacity: 0.85;
}
.button:hover{
  opacity: 1;
  color: #FFFF33 !important;
}

</style>