<template>
  <BtnSecondary @click="$inertia.get(back($page.props.back))">
    Назад
  </BtnSecondary>
</template>

<script setup>
function back(fullUrl) {
  return (new URL(fullUrl)).pathname
}
</script>