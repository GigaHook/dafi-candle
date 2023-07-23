<template>
  <v-btn
    icon
    class="rounded"
    height="44"
    width="44"
    variant="tonal"
    color="yellow"
  >
    <slot/>
  </v-btn>
</template>
<script>
export default {
  name: 'FormIconBtn'
}
</script>