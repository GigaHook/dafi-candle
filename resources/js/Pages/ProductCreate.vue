<template>
  <v-img src="img" class="position-absolute" cover eager>
    <template #sources>
      <source srcset="../../../public/storage/assets/images/main2.jpg">
    </template>
  </v-img>

  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col xs="12" md="9" xl="6">
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
            <h2 class="text-h5 mb-4">Характеристики</h2>
            <!--теги-->
            <v-slide-x-transition group>
              <div v-for="tag in tags" :key="tag.key" class="d-flex">
                <FormInput v-model="tag.name" label="Название" class="w-50 me-4"/>
                <FormInput v-model="tag.value" label="Значение" class="w-50 me-4"/>
                <FormIconBtn @click="removeTag(tag.key)" color=grey>
                  <v-icon icon="mdi-close"/>
                </FormIconBtn>
              </div>
            </v-slide-x-transition>
            <FormIconBtn @click="addTag" class="mt-n1">
              <v-icon icon="mdi-plus"/>
            </FormIconBtn>
            
            <v-divider class="my-4"/>
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
import FormIconBtn from '../Components/FormIconBtn.vue'
export default {
  layout: AppLayout,
  components: {
    FormIconBtn: FormIconBtn,
  },
  data() {
    return {
      name: null,
      description: null,
      image: null,
      type: null,
      price: null,
      tags: [],
    }
  },
  methods: {
    submit() {
      this.$router.post(route('products.store'), {
        name: this.name,
        description: this.description,
        image: this.image,
        type_id: this.defineTypeId(this.type),
        price: this.price,
        tags: this.tags
      }, {
        headers: { 'Content-Type': 'multipart/form-data' },
        forceFormData: true,
      })
    },
    cancel() {
      this.name = null
      this.description = null
      this.image = null
      this.type = null
      this.price = null
      this.$router.get(route('products.index'))
    },
    defineTypeId(type) {
      return this.$page.props.types.find(elem => elem.name == type).id
    },
    addTag() {
      this.tags.push({
        name: null,
        value: null,
        key: Math.random().toFixed(5),
      })
    },
    removeTag(key) {
      this.tags = this.tags.filter(elem => elem.key != key)
    }
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