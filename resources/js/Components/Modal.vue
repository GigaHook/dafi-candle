<template>
  <v-dialog
    v-model="dialog"
    activator="parent"
    scrim="black"
  >
    <v-row class="justify-center">
      <v-col lg="4">
        <v-card class="position-relative pb-3 px-1" style="overflow: visible;">
          <v-btn
            @click="dialog = false"
            icon="mdi-close"
            class="position-absolute right-0 me-n10"
            size="36"
          />

          <v-card-title>
            <slot name="title"/>
          </v-card-title>

          <v-card-text class="text-body-1">
            <slot name="text"/>
          </v-card-text>

          <div class="d-flex">
            <BtnSecondary
              v-if="!noDeny"
              @click="handle('deny')"
              class="ms-2"
            >
              {{ denyText }}
            </BtnSecondary>
  
            <v-spacer/>
  
            <BtnPrimary @click="handle('confirm')" class="me-2">
              {{ confirmText }}
            </BtnPrimary>
          </div>

        </v-card>
      </v-col>
    </v-row>
  </v-dialog>
</template>

<script setup>
import { ref } from 'vue'

const dialog = ref(false)

const emit = defineEmits('confirm', 'deny')

const props = defineProps({
  noDeny: {
    type: Boolean,
    required: false,
    default: false,
  },
  confirmText: {
    type: String,
    required: false,
    default: 'Ок',
  },
  denyText: {
    type: String,
    required: false,
    default: 'Отмена',
  }
})

function handle(option) {
  emit(option)
  dialog.value = false
}


</script>

<style scoped>

</style>