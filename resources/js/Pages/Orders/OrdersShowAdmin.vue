<template>
  <Head :title="`Заказ №${order.id}`"/>
  <v-container :fluid="display.mdAndDown.value">
    <v-row justify="center">
      <v-col cols="12" md="6" xl="5">
        <v-card class="px-4 pt-2 pb-3" elevation="3">
          <h2 class="text-h5 mb-2">
            Заказ №{{ order.id }}
          </h2>

          <ListRow 
            left="Заказчик"
            :right="`${order.adress.name} ${order.adress.lastname} ${order.adress.patronymic}`"
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
            left="Доставка"
            :right="order.adress.type"
          />
          
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

          <ListRow 
            left="Статус"
            class="text-h6"
          >
            <template #right>
              <OrdersSelectStatus
                v-if="$page.props.user.is_admin"
                :order="order"
                style="min-width:180px !important"
                class="ms-n2 mt-n1"
              />
              <StatusChip
                v-else
                :status="order.status"
                style="min-width:fit-content !important"
              />
            </template>
          </ListRow>  

          <BtnBack v-if="display.mdAndUp.value">
            Назад
          </BtnBack>
        </v-card>
      </v-col>

      <v-col cols="12" md="6" xl="5">
        <v-card class="pa-4 pt-2" elevation="3">
          <h2 class="text-h5 mb-3">
            Содержание
          </h2>

          <OrderItemCard 
            v-for="product in order.products"
            :key="product.id"
            :product="product"
            :order="order"
            :editable="!!$page.props.user.is_admin"
            :last="product.id == order.products.at(-1).id"
          />
          
          <BtnPrimary
            v-if="$page.props.user.is_admin"
            class="mt-2"
            @click="$inertia.get(route('orders.edit', order.id))"
          >
            Добавить
          </BtnPrimary>

          <BtnSecondary
            v-if="!$page.props.user.is_admin"
            :disabled="order.status != 'В работе'"
            :style="order.status != 'В работе' ? 'opacity: .5' : ''"
            class="mt-2"
          >
            Отменить заказ
            <Modal
              @confirm="updateStatus('Отменён')"
              title="Подтверждение"
              text="Вы действительно хотите отменить заказ?"
            />
          </BtnSecondary>

          <BtnBack
            v-if="display.smAndDown.value"
            class="mt-2"
          >
            Назад
          </BtnBack>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import OrdersSelectStatus from '@/Components/OrdersSelectStatus.vue'
import ListRow from '@/Components/ListRow.vue'
import OrderItemCard from '@/Components/OrderItemCard.vue'
import StatusChip from '@/Components/StatusChip.vue'

import { defineComponent } from 'vue'
import { useOrder } from '@/Composables/useOrder'
import { useDisplay } from 'vuetify'

defineOptions({ layout: AppLayout })
defineComponent({
  OrdersSelectStatus,
  ListRow,
  OrderItemCard,
  StatusChip,
})

const { order } = defineProps({ order: Object })
const { creationDate, creationTime, updateStatus } = useOrder(order)
const display = useDisplay()
</script>