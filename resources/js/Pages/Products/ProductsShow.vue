<template>
  <Head title=""/>
  <div>
    {{ product }}
  </div>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue'
export default {
  layout: AppLayout,
  props: {
    product: Object,

  }
}
</script>

<style scoped>

</style>