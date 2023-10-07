<template>
  <Head title="Добавить товар"/>
  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col xs="12" sm="8" md="7" lg="6" xl="4">
        <v-card class="px-4 pt-2 pb-4" elevation="3">
          <v-form 
            @submit.prevent="submit" 
            ref="form" 
            validate-on="blur" 
            :disabled="loading"
          >
            <h1 class="text-h4 mb-4">Добавить товар</h1>
            <FormInput
              name="name"
              type="text"
              label="Название"
              v-model="name"
              :rules="[rules.required, rules.name]"
            />
            <v-textarea
              name="description"
              label="Описание"
              v-model="description"
              :rules="[rules.required, rules.description]"
              variant="outlined"
              color="yellow"
              class="mb-3"
            />
            <v-file-input
              name="image"
              label="Изображение"
              v-model="image"
              :rules="[rules.required]"
              variant="outlined"
              color="yellow"
              density="compact"
              class="mb-3"
              accept="image/*"
              prepend-icon
              :error-messages="errors.image"
              @update:model-value="errors = {}"
            >
              <template #append-inner>
                <v-divider vertical class="me-3"/>
                <v-icon icon="mdi-image-outline"/>
              </template>
            </v-file-input>
            <v-select
              name="type"
              label="Тип"
              v-model="type"
              :rules="[rules.required]"
              :items="types"
              variant="outlined"
              color="yellow"
              density="compact"
              class="mb-3"
              menu-icon="mdi-chevron-down"
            />
            <FormInput
              name="price"
              type="text"
              label="Цена"
              v-model="price"
              :rules="[rules.required]"
              v-mask="'##############'"
            />
            
            <h2 class="text-h5 mb-4">Характеристики</h2>
            <v-slide-x-transition group>
              <div v-for="(tag, index) of tags" :key="index" class="d-flex">
                <FormInput
                  v-model="tag.name" 
                  label="Название" 
                  class="w-50 me-4" 
                  :rules="[rules.required]"
                />
                <FormInput v-model="tag.value" label="Значение" class="w-50 me-4"/>
                <FormIconBtn @click="removeTag(index)" color="red">
                  <v-icon icon="mdi-close"/>
                </FormIconBtn>
              </div>
            </v-slide-x-transition>
            
            <FormIconBtn @click="addTag" class="mt-n1">
              <v-icon icon="mdi-plus"/>
            </FormIconBtn>
            
            <v-divider class="my-4"/>
            <div class="d-flex justify-space-between">
              <BtnPrimary type="submit" :loading="loading">
                Добавить
              </BtnPrimary>
              <BtnSecondary @click="cancel">
                Назад
              </BtnSecondary>
            </div>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue'
import FormIconBtn from '../../Components/FormIconBtn.vue'
export default {
  layout: AppLayout,
  components: {
    FormIconBtn: FormIconBtn,
  },
  props: {
    errors: Object,
  },
  data() {
    return {
      name: null,
      description: null,
      image: null,
      type: null,
      price: null,
      tags: [],
      rules: {
        required: v => !!v || 'Это поле нужно заполнить',
        name: v => (v.length >= 4 && v.length <= 50) || 'От 4 до 50 символов',
        description: v => v?.length <= 700 || 'До 700 символов',
      },
      loading: false,
    }
  },
  methods: {
    submit() {
      this.$refs.form.validate()
      if (this.$refs.form.isValid) 
      this.$router.post(route('products.store'), {
        name: this.name,
        description: this.description,
        image: this.image[0],
        type_id: this.preparedType,
        price: this.price,
        tags: this.preparedTags
      }, {
        forceFormData: true,
        preserveScroll: true,
        onStart: this.loadingStart,
        onSuccess: this.formReset,
        onFinish: this.loadingEnd,
      })
    },
    loadingStart() {
      this.loading = true
    },
    loadingEnd() {
      this.loading = false
    },
    formReset() {
      this.$refs.form.reset()
    },
    cancel() {
      this.formReset()
      this.loadingEnd()
      this.$router.get(route('products.index'))
    },
    addTag() {
      this.tags.push({
        name: null,
        value: null,
      })
    },
    removeTag(index) {
      this.tags.splice(index, 1)
    },
  },
  computed: {
    types() {
      return this.$page.props.types.map(elem => elem.name)
    },
    preparedType() {
      return this.$page.props.types.find(elem => elem.name == this.type).id
    },
    preparedTags() {
      return this.tags.filter(elem => elem.name)
    },
  },
  mounted() {
    this.type = this.types[0] ?? 'Обычный'
  }
}
</script>

<style scoped>

</style>