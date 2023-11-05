<template>
  <Head title="Мой профиль"/>
  <v-container fluid>
    <v-row justify="center">
      <v-col cols="12" lg="8" md="10">
        <v-card
          class="fill-height d-flex flex-column justify-space-between px-4 pt-2 pb-3"
          elevation="3"
        >
          <div class="d-flex justify-space-between">
            <v-list>
              <h1 class="text-h5 mt-n2">Мой профиль</h1>
              <v-list-item prepend-icon="mdi-account" subtitle="Имя">
                {{ $page.props.user.name }}
              </v-list-item>
            
              <v-list-item prepend-icon="mdi-phone" subtitle="Телефон">
                {{ $page.props.user.tel }}
              </v-list-item>
            
              <v-list-item prepend-icon="mdi-email" subtitle="Почта">
                {{ $page.props.user.email }}
              </v-list-item>

              <v-list-item v-if="$page.props.user.is_admin">
                Вы являетесь администратором сайта
              </v-list-item>
            </v-list>

            <v-btn
              color="red"
              variant="tonal"
              class="mt-2"
            >
              Выйти
              <Modal
                @confirm="$inertia.post('/logout')"
                title="Подтверждение"
                text="Вы действительно хотите выйти из аккаунта?"
              />
            </v-btn>
          </div>

          <v-divider class="mt-2 mb-4"/>

          <h2 class="text-h6">Мои заказы</h2>
          <v-table density="compact" v-if="orders.length">
            <thead>
              <tr>
                <th>Дата</th>
                <th>Стоимость</th>
                <th>Статус</th>
                <th></th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              <ProfileOrderTableRow
                v-for="order in orders"
                :order="order"
                :key="order.id"
              />
            </tbody>
          </v-table>

          <div v-else class="text-center text-grey my-2">
            Вы ещё не сделали ни один заказ
          </div>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { defineComponent } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue'
import ProfileOrderTableRow from '@/Components/ProfileOrderTableRow.vue'

defineComponent({ ProfileOrderTableRow })
defineOptions({ layout: AppLayout})
defineProps({ orders: Array })
</script>

<style scoped>

</style>