<template>
  <Head :title="`Заказ №${order.id}`"/>
  <v-container>
    <v-card class="px-4 pt-2 pb-3" elevation="3">
      <v-row>
        <v-col
          cols="12"
          md="6"
          :class="display.mdAndUp.value ?? 'pe-4'"
        >

          <div class="text-h5 mb-2">
            Заказ №{{ order.id }}
          </div>

          <ListRow 
            left="Заказчик"
            :right="`${order.adress.name} ${order.adress.lastname} ${order.adress.patronymic}`"
          />

          <ListRow 
            left="Доставка"
            :right="order.adress.type"
          />
          
          <ListRow 
            left="Номер телефона"
            :right="order.adress.tel"
          />

          <ListRow 
            left="Дата оформления"
            :right="creationDate + ' ' + creationTime"
          />

          <div class="d-flex">
            <ListRow 
              left="Стоимость"
              :right="order.price"
              class="w-100"
            />
            <v-icon icon="mdi-currency-rub" size="18" class="pt-1"/>  
          </div>

          <ListRow 
            left="Статус"
            class="text-h6"
          >
            <template #right>
              <OrdersSelectStatus
                :order="order"
                style="min-width:170px !important"
                class="ms-n2 mt-n1"
              />
            </template>
          </ListRow>

        </v-col>

        <v-divider v-if="display.mdAndUp.value" vertical class="my-4"/>

        <v-col cols="12" md="6" class="ps-4">

            <div class="text-h5 mb-2">
              Адрес
            </div>

            <ListRow 
              left="Город"
              :right="order.adress.city"
            />

            <ListRow 
              left="Улица"
              :right="order.adress.street"
            />

            <ListRow 
              left="Дом"
              :right="order.adress.house_number"
            />

            <ListRow 
              v-if="order.adress.flat_number"
              left="Квартира"
              :right="order.adress.flat_number"
            />

            <ListRow 
              v-if="order.adress.postal_code"
              left="Почтовый индекс"
              :right="order.adress.postal_code"
            />

          </v-col>
        </v-row>
      </v-card>
  
  </v-container>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import OrdersSelectStatus from '@/Components/OrdersSelectStatus.vue'
import ListRow from '@/Components/ListRow.vue'

import { defineComponent } from 'vue'
import { useOrder } from '@/Composables/useOrder'
import { useDisplay } from 'vuetify/lib/framework.mjs'

defineOptions({ layout: AppLayout })
defineComponent({ OrdersSelectStatus, ListRow })

const { order } = defineProps({ order: Object })
const { creationDate, creationTime } = useOrder(order)
const display = useDisplay()
//fix display

</script>