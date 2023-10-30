<template>
  <v-dialog
    v-model="dialog"
    activator="parent"
    scrim="black"
  >
    <v-row class="justify-center">
      <v-col cols="10" sm="8" md="6" lg="4" xl="3">
        <v-card class="position-relative pb-3 px-1" style="overflow: visible;">
          <v-btn
            @click="dialog = false"
            icon="mdi-close"
            class="position-absolute right-0 me-n10"
            size="36"
          />

          <v-card-title class="text-wrap">
            {{ title }}
          </v-card-title>

          <v-card-text class="text-body-1">
            {{ text }}
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
  },
  title: {
    type: String,
    required: false,
    default: 'Подтверждение',
  },
  text: {
    type: String,
    required: false,
  },
})

const dialog = ref(false)
const emit = defineEmits('confirm', 'deny')

function handle(option) {
  emit(option)
  dialog.value = false
}

</script>

<style scoped>

</style>