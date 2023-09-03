<template>
  <v-snackbar
    v-for="(snackbar, index) in snackbars"
    :key="Math.random(3)"
    :style="`bottom: ${index * 60}px`"
    :model-value="!!snackbar.isShown"
    @update:model-value="snackbar.isShown = false"
    timeout="4000"
  >
    {{ snackbar.text }}
  </v-snackbar>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

const page = usePage()
const snackbars = ref([])

router.on('finish', () => {
  snackbars.value.push(page.props.snackbar)
  console.log(snackbars.value);
})

</script>

<style scoped>

</style>