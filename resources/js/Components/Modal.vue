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
              v-if="denyText"
              @click="handleDeny"
              class="ms-2"
            >
            {{ denyText ?? 'Отмена' }}
            </BtnSecondary>
  
            <v-spacer/>
  
            <BtnPrimary @click="handleConfirm" class="me-2">
              {{ confirmText ?? 'Ок' }}
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

const props = defineProps({
  confirmAction: {
    type: Function,
    required: false,
  },
  confirmText: {
    type: String,
    required: false,
  },
  denyAction: {
    type: Function,
    required: false,
  },
  denyText: {
    type: String,
    required: false,
  }
})

function handleConfirm() {
  props.confirmAction?.()
  dialog.value = false
}

function handleDeny() {
  props.denyAction?.()
  dialog.value = false
}

</script>

<style scoped>

</style>