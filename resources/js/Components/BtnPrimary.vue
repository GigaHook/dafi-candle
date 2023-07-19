<template>
  <v-btn color="primary" v-ripple="{ class:'text-yellow' }">
    <slot/>
  </v-btn>
</template>

<script>
export default {
  name: 'BtnPrimary'
}
</script>