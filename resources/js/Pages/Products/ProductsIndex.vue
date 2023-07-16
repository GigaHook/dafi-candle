<template>
  <Head title="Каталог"/>

  <v-container fluid>
    <v-row style="min-height: calc(100vh - 72px);">
      <v-col
        style="background-color: #ccc;"
        cols="12"
        sm="12"
        md="4"
        lg="3"
        xl="2"
        order-sm="2"
        order-md="1"
      >
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet sunt ducimus optio quam deserunt voluptatibus, sint ad cum officiis tenetur, consectetur quidem. Hic voluptas suscipit ad nobis sed explicabo error.
      </v-col>

      <v-col
        style="background-color: #eee;"
        cols="12"
        sm="12"
        md="8"
        lg="9"
        xl="10"
        order-sm="1"
        order-md="2"
      >
        <v-row class="fill-height">
          <v-col
            v-for="product in products.data"
            xl="3"
            lg="4"
            md="6"
            sm="6"
          >
            <v-card>
              <v-img :src="$page.props.storage + product.image"/>
            </v-card>
          </v-col>
          <v-col cols="12" class="self-end py-0">
            <v-pagination
              :length="products.last_page"
              v-model="products.current_page"
              @next="next"
              @prev="prev"
              @update:modelValue="to"
            />
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
export default {
  layout: AppLayout,
  components: {
    Head,
  },
  props: {
    products: Object,
  },
  data() {
    return {

    }
  },
  methods: {
    next() {
      this.$router.get(this.products.next_page_url)
    },
    prev() {
      this.$router.get(this.products.prev_page_url)
    },
    to(page) {
      this.$router.get(this.products.links[page].url)
    }

  },
  mounted() {

  }
}
</script>

<style scoped>

</style>