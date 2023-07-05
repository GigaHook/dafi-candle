<template>
  <Link :href="to">
    <v-btn
      variant="plain"
      style="opacity: 1 !important; color: white;"
      :color="$page.url === to ? 'secondary' : 'white'"
      size="large"
      v-ripple="{ class: 'text-yellow'}"
    >
      <slot/>
    </v-btn>
  </Link>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
  components: {
    Link
  },
  props: {
    to: String
  },
}

</script>

<style scoped>

</style>