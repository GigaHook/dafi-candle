<template>
  <v-img src="img" class="position-absolute" cover eager>
    <template #sources>
      <source srcset="../../../public/storage/assets/images/main2.jpg">
    </template>
  </v-img>
  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col xs="12" md="8" xl="6">
        <v-card class="px-5 pb-5 pt-3" color="black">
          <v-form @submit.prevent="submit">
            <h1 class="text-h4 mb-4">Добавить товар</h1>
            <FormInput
              name="name"
              type="text"
              label="Название"
              v-model="name"
              required
            />
            <v-textarea
              name="description"
              label="Описание"
              v-model="description"
              required
              variant="outlined"
              color="yellow"
            />
            <v-file-input
              name="iamge"
              label="Изображение"
              v-model="image"
              required
              variant="outlined"
              color="yellow"
              density="compact"
              accept="image/*"
              prepend-icon
            />
            <v-select
              name="type"
              label="Тип"
              v-model="type"
              required
              :items="types"
              variant="outlined"
              color="yellow"
              density="compact"
            />
            <FormInput
              name="price"
              type="tel"
              label="Цена"
              v-model="price"
              required
            />
            <div class="d-flex justify-space-between">
              <BtnPrimary type="submit">
                Добавить
              </BtnPrimary>
              <BtnSecondary @click="cancel">
                Отмена
              </BtnSecondary>
            </div>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import AppLayout from '../Layouts/AppLayout.vue'
export default {
  layout: AppLayout,
  data() {
    return {
      name: null,
      description: null,
      image: null,
      type: null,
      price: null,
    }
  },
  methods: {
    submit() {
      this.$router.post('products.store', {
        name: this.name,
        description: this.description,
        image: this.image,
        type: this.defineType(this.type),
        price: this.price,
      }, {
        forceFormData: true,
      })
    },
    cancel() {
      this.name = null
      this.description = null
      this.image = null
      this.type = null
      this.price = null
      this.$router.get('product.index')
    },
    defineType(type) {
      return this.$page.props.types.find(elem => elem.name == type).id
    },
  },
  computed: {
    types() {
      return this.$page.props.types.map(type => type.name)
    },
  },
}
</script>

<style scoped>

</style>