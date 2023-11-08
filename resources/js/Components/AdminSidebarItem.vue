<template>
  <v-list-item>

    <template #title="raw" v-if="badge">
      <div class="d-flex justify-space-between ps-2">
        {{ raw.title }}
        <v-badge :content="badge" color="red" inline/>
      </div>
    </template>

    <template #title="raw" v-else>
      <div class="ps-2">
        {{ raw.title }}
      </div>
    </template>

    <template #prepend>
      <v-badge v-if="badge" dot floating color="red">
        <v-icon :icon="icon"/>
      </v-badge>

      <v-icon :icon="icon" v-else/>
    </template>

  </v-list-item>
</template>

<script setup>

defineProps({
  icon: String,
  badge: Number,
})

</script>
