<template>
  <div>
<<<<<<< HEAD
    Ürünler listesi
=======
    Ürünler listesi 2
>>>>>>> 50ec0615f45b65cf1eb4b58f6530eee7522c93a5
    <li v-for="(item, index) in products" :key="index">
      {{ item.prodName }}
    </li>
  </div>
</template>

<script>
export default {
  name: "productIndexComponent",
  data() {
    return {
      products: this.prproducts
    }
  },
  props: {
    prproducts: {
      type: Array,
      required: false,
      default: function () {
        return []
      }
    }
  }
}
</script>