<template>
  <Head title="Оформление заказа"/>
  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col xs="12" md="7" xl="5">
        <v-card class="px-4 pt-2 pb-4" elevation="3">

          <h1 class="text-h5">Оформление заказа</h1>

          <v-tabs v-model="tab" fixed-tabs>
            <v-tab name="cdek">Доставка по СДЭК</v-tab>
            <v-tab name="post">Доставка по Почте РФ</v-tab>
          </v-tabs>
          
          <v-window v-model="tab">
            <v-window-item value="cdek">
              <v-form 
                @submit.prevent="cdekSubmit"
                validate-on="blur" 
                :disabled="loading"
                ref="postVForm"
              >
                <h2 class="text-h6 my-2">Адрес доставки</h2>
                <v-row dense>

                  <v-col cols="6" class="mb-n2">
                    <FormInput
                      v-model="postFormData.city"
                      :rules="[rules.required, rules.max]"
                      label="Город"
                      type="text"
                    />
                  </v-col>

                  <v-col cols="6" class="mb-n2">
                    <FormInput
                      v-model="postFormData.house_number"
                      :rules="[rules.required, rules.max]"
                      label="Дом/строение"
                      type="text"
                    />
                  </v-col>

                  <v-col cols="6" class="mb-n2">
                    <FormInput
                      v-model="postFormData.street"
                      :rules="[rules.required, rules.street]"
                      label="Улица, проспект"
                      type="text"
                    />
                  </v-col>

                  <v-col cols="6" class="mb-n2">
                    <FormInput
                      v-model="postFormData.flat_number"
                      :rules="[rules.required, rules.max]"
                      label="Квартира, помещение"
                      type="text"
                    />
                  </v-col>

                </v-row>

                <h2 class="text-h6 mb-2">Контактные данные</h2>

                <FormInput
                  v-model="postFormData.name"
                  :rules="[rules.required, rules.max]"
                  label="Имя"
                  type="text"
                />
                <FormInput
                  v-model="postFormData.lastname"
                  :rules="[rules.required, rules.max]"
                  label="Фамилия"
                  type="text"
                />
                <FormInput
                  v-model="postFormData.middlename"
                  :rules="[rules.required, rules.max]"
                  label="Отчество"
                  type="text"
                />
                <BtnPrimary>
                  Оформить заказ
                </BtnPrimary>
              </v-form>
            </v-window-item>

            <v-window-item value="cdek">
              <v-form 
                @submit.prevent="cdekSubmit"
                validate-on="blur" 
                :disabled="loading"
              >
              <FormInput
                  v-model="postFormData.postal_сode"
                  :rules="[rules.required, rules.max]"
                  label="Почтовый индекс"
                  type="tel"
                  v-mask="'######'"
                />
              </v-form>
            </v-window-item>
          </v-window>

        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'

const cart = defineProps({
  cart: Object
})

const tab = ref('cdek')
const loading = ref(false)
const postVForm = ref()
const cdekVForm = ref()

const rules = {
  required: v => !!v || 'Это поле нужно заполнить',
  max: v => v >= 50 || 'Слишком длинное значение',
  street: v => v >= 150 || 'Слишком длинное значение',
}

const postFormData = useForm({
  city: null,
  street: null,
  house_number: null,
  flat_number: null,
  postal_code: null,
  name: null,
  lastname: null,
  middlename: null,
})

const cdekFormData = useForm({

})

function postSubmit() {

}

function cdekSubmit() {

}

</script>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
  layout: AppLayout
}
</script>

<style scoped>

</style>