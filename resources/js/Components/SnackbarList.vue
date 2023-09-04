<template>
  <v-snackbar
    v-for="(snackbar, index) in snackbars"
    :key="Math.random(3)"
    :style="`bottom: ${index * 60}px`"
    @update:model-value="snackbars.splice(index, 1)"
    timeout="4000"
  >
    {{ snackbar.text }}
  </v-snackbar>
</template>

<script setup>
import { reactive } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

const page = usePage()
const snackbars = reactive([])

router.on('finish', () => {
  snackbars.push(page.props.snackbar)
  console.log(snackbars);
})

</script>

<style scoped>

</style>