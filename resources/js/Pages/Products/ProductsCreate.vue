<template>
  <Head title="Добавить товар"/>
  <v-container>
    <v-row class="justify-center align-center" style="min-height: 90vh;">
      <v-col xs="12" md="9" xl="6">
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
            />
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
        required: text => !!text || 'Это поле нужно заполнить',
        name: text => (text.length >= 4 && text.length <= 50) || 'От 4 до 50 символов',
        description: text => text?.length <= 700 || 'До 700 символов',
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
    resetErrors() {
      this.form

    }
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