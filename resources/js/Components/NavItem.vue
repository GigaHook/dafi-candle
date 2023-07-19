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
  </v-btn>
</template>

<script>
export default {
  name: 'NavItem',
  props: {
    active: {
      type: Boolean,
      required: false,
    }

  }
}
</script>

<style scoped>
.button{
  opacity: 0.85;
}
.button:hover{
  opacity: 1;
  color: #FFFF33 !important;
}
.active{
  opacity: 1;
  color: #FFFF33 !important;
}
</style>