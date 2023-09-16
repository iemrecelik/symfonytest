/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import Vue from 'vue';

import product from './components/product/Index.vue';
import author from './components/author/CreateComponent.vue';

/**
* Create a fresh Vue Application instance
*/
new Vue({
  el: '#app',
  components: {product, author}
});

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
