<template>
  <v-dialog
    v-model="dialog"
    activator="parent"
  >
    <v-row class="justify-center">
      <v-col lg="6">
        <v-card>

          <v-card-text>
            
          </v-card-text>
          <v-card-actions>
            <v-spacer/>

            <v-btn @click="action">
              
            </v-btn>

          </v-card-actions>
          
        </v-card>
      </v-col>
    </v-row>
  </v-dialog>
</template>

<script setup>
import { ref } from 'vue'

const dialog = ref(false)

defineProps({
  action,
})

</script>

<style scoped>

</style>