<template>
  <div>
    Ürünler listesi
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