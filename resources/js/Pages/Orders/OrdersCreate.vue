<template>
  <Head title="Оформление заказа"/>
  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col xs="12" sm="8" md="7" lg="6" xl="4">
        <v-card class="px-4 pt-2 pb-4" elevation="3">

          <h1 class="text-h5 mb-2">Оформление заказа</h1>

          <v-tabs v-model="tab" fixed-tabs>
            <v-tab name="cdek">Доставка по СДЭК</v-tab>
            <v-tab name="post">Доставка по Почте РФ</v-tab>
          </v-tabs>
          
          <v-window v-model="tab">
            <v-window-item value="cdek">
              <v-form 
                @submit.prevent
                validate-on="blur" 
                :readonly="cdekFormData.processing"
                ref="cdekVForm"
              >
                <h2 class="text-h6 my-2">
                  Адрес доставки
                  <sup class="text-grey text-subtitle-2">*отделения СДЭК</sup>
                </h2>

                <v-row dense>
                  
                  <v-col cols="6" class="mb-n2">
                    <FormInput
                      v-model="cdekFormData.city"
                      :rules="[rules.required, rules.max]"
                      label="Город"
                      type="text"
                    />
                  </v-col>

                  <v-col cols="6" class="mb-n2">
                    <FormInput
                      v-model="cdekFormData.house_number"
                      :rules="[rules.required, rules.max]"
                      label="Дом, строение"
                      type="text"
                    />
                  </v-col>

                  <v-col cols="6" class="mb-n2">
                    <FormInput
                      v-model="cdekFormData.street"
                      :rules="[rules.required, rules.street]"
                      label="Улица"
                      type="text"
                    />
                  </v-col>

                  <v-col cols="6" class="mb-n2">
                    <FormInput
                      v-model="cdekFormData.flat_number"
                      :rules="[rules.max]"
                      label="Квартира, помещение"
                      type="text"
                    />
                  </v-col>

                </v-row>

                <h2 class="text-h6 mb-2">Контактные данные</h2>

                <FormInput
                  v-model="cdekFormData.name"
                  :rules="[rules.required, rules.max]"
                  label="Имя"
                  type="text"
                />
                <FormInput
                  v-model="cdekFormData.lastname"
                  :rules="[rules.required, rules.max]"
                  label="Фамилия"
                  type="text"
                />
                <FormInput
                  v-model="cdekFormData.patronymic"
                  :rules="[rules.required, rules.max]"
                  label="Отчество"
                  type="text"
                />
                <FormInput
                  v-model="cdekFormData.tel"
                  :rules="[rules.required, rules.max]"
                  label="Телефон"
                  type="tel"
                  v-mask="'+7 (###) ###-##-##'"
                />

              </v-form>
            </v-window-item>

            <v-window-item value="post">
              <v-form 
                @submit.prevent
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
                      label="Дом, строение"
                      type="text"
                    />
                  </v-col>

                  <v-col cols="6" class="mb-n2">
                    <FormInput
                      v-model="postFormData.street"
                      :rules="[rules.required, rules.street]"
                      label="Улица"
                      type="text"
                    />
                  </v-col>

                  <v-col cols="6" class="mb-n2">
                    <FormInput
                      v-model="postFormData.flat_number"
                      :rules="[rules.max]"
                      label="Квартира, помещение"
                      type="text"
                    />
                  </v-col>

                  <v-col cols="12" class="mb-n2">
                    <FormInput
                      v-model="postFormData.postal_code"
                      :rules="[rules.required, rules.postalCode]"
                      label="Почтовый индекс"
                      type="tel"
                      v-mask="'######'"
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
                  v-model="postFormData.patronymic"
                  :rules="[rules.required, rules.max]"
                  label="Отчество"
                  type="text"
                />
                <FormInput
                  v-model="postFormData.tel"
                  :rules="[rules.required, rules.max]"
                  label="Телефон"
                  type="tel"
                  v-mask="'+7 (###) ###-##-##'"
                />
                
              </v-form>
            </v-window-item>
          </v-window>

          <div class="d-flex justify-space-between align-center pt-1">
            <BtnPrimary :loading="loading">
              Оформить заказ
              <Modal 
                @confirm="tab == 0 ? cdekSubmit() : postSubmit()"
                :confirm-text="'Оформить'"
              />
              <!--я тут нагадил-->
            </BtnPrimary>
            
            <BtnSecondary @click="$router.get(route('cart.index'))" :disabled="loading">
              Отмена
            </BtnSecondary>
          </div>

        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'

defineComponent({
  Modal: Modal,
})

const cart = defineProps({
  cart: Object
})

const tab = ref('cdek')
const loading = ref(false)
const cdekVForm = ref()
const postVForm = ref()
const page = usePage()
const user = computed(() => page.props.user)

const rules = {
  required: v => !!v || 'Это поле нужно заполнить',
  max: v => v?.length <= 50 || 'Слишком длинное значение',
  street: v => v?.length <= 150 || 'Слишком длинное значение',
  postalCode: v => v?.length == 6 || 'Почтовый индекс должен состоять из 6 цифр'
}

const cdekFormData = useForm({
  type:         'СДЭК',
  city:         null,
  house_number: null,
  street:       null,
  flat_number:  null,
  name:         null,
  lastname:     null,
  patronymic:   null,
  tel:          null,
})

const postFormData = useForm({
  type:         'Почта РФ',
  city:         null,
  house_number: null,
  street:       null,
  flat_number:  null,
  postal_code:  null,
  name:         null,
  lastname:     null,
  patronymic:   null,
  tel:          null,
})

async function cdekSubmit() {
  if (await cdekVForm.value.validate()) {
    cdekFormData.post(route('orders.store'), {
      preserveScroll: true,
      preserveState: true,
      onStart: () => loading.value = true,
      onFinish: () => loading.value = false
    })
  }
}

async function postSubmit() {
  if (await postVForm.value.validate()) {
    postFormData.post(route('orders.store'), {
      preserveScroll: true,
      preserveState: true,
      onStart: () => loading.value = true,
      onFinish: () => loading.value = false
    })
  }
}

onMounted(() => {
  cdekFormData.name = user?.value.name
  postFormData.name = user?.value.name
  cdekFormData.tel = user?.value.tel
  postFormData.tel = user?.value.tel
})

</script>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineComponent } from 'vue';

export default {
  layout: AppLayout
}
</script>

<style scoped>

</style>