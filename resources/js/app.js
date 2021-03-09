const { default: axios } = require('axios');

require('./bootstrap');
window.Vue = require('vue');
const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
function  init() {
  const app = new Vue({
      el: '#app',
      mounted: function () {
       this.$nextTick(function () {
         console.log("App montata!");
         this.getRestaurantsInit();
         // msg payment
         this.messageVisible = true,
         setTimeout(function(scope){
           scope.messageVisible = false;
         }, 5000, this);
       })},
      data: {
          restaurants: [],
          plates: [],
          cart: [],
          order: [],

          // ricerca
          searchInput: "",
          oldSearchInput: "",
          searchResult: [],

          // search bar flags
          result_tendina: 0,
          no_result: 0,
          research_error: 0,
          research_category: 0,
          research_restaurants: 0,
          research_plates: 0,

          messageVisible: '',
          loading: 0,

          // page flags
          displayRestaurants: 1,
          displayPlates: 0,


      },
      computed: {

        cart_new: function() {

          let cart_order = [];
          this.cart.forEach(element => {

            if(!cart_order.some(plate => plate.plate_id == element.plate_id)) {

              let new_element = element;
              new_element['quantity'] = 1;
              cart_order.push(new_element);

            } else {

              for(let i=0; i<cart_order.length; i++) {

                if(cart_order[i].plate_id == element.plate_id) {

                  cart_order[i].quantity++;

                  cart_order[i].plate_price = parseFloat(cart_order[i].quantity).toFixed(2) *
                  parseFloat(element.plate_price).toFixed(2);

                  cart_order[i].plate_price = cart_order[i].plate_price.toFixed(2);
                }
              }
            }
          });

          return cart_order;
        },

        total: function() {

          let total = 0;
          for (let i = 0; i < this.cart_new.length; i++) {
            total += parseFloat(this.cart_new[i].plate_price);
          }
          return total.toFixed(2);
        },

        search_typologies_result: function(){
          return this.searchResult.typology_resoult;
        },

        search_rest_name_result: function(){
          return this.searchResult.rest_name_resoult;
        },

        search_plate_name_result: function(){
          return this.searchResult.plates_resoult;
        },

      },

      watch: {
        searchInput: function(newVal){
          if (newVal === "") {
            this.result_tendina = 0;
          }
        },
      },
      methods: {

        getRestaurantsInit: function(){
          axios.get('/getrestaurantsinit', {
            params: {
            }
            })
            .then((response) => {
              console.log('Primi ristoranti casuali: ', response.data.restaurants);
              this.restaurants = response.data.restaurants;
            })
            .catch(function (error) {
              console.log(error);
            })
        },

        startResearch: function(queries){
          console.log(queries);
          this.oldSearchInput = queries;
          this.loading = 1;
          this.result_tendina = 1;
          this.no_result = 0;
          this.research_error = 0;
          this.research_category = 0;
          this.research_restaurants = 0;
          this.research_plates = 0;
          axios.get('/search/' + queries, {
            params: {
            }
            })
            .then((response) => {
              this.searchResult = response.data;
              this.$forceUpdate();
              this.result_tendina = 1;
              this.loading = 0;
              if (response.data.error) {
                console.log(response.data.error);
                this.research_error = 1;
              } else if (
                response.data.typology_resoult.length === 0 &&
                response.data.rest_name_resoult.length === 0 &&
                response.data.plates_resoult.length === 0
              ) {
                this.no_result = 1;
              } else {
                if (this.searchResult.typology_resoult.length != 0) {
                  this.research_category = 1;
                }
                if (this.searchResult.rest_name_resoult.length != 0) {
                  this.research_restaurants = 1;
                }
                if (this.searchResult.plates_resoult.length != 0) {
                  this.research_plates = 1;
                }
              }

              console.log('ALL', this.searchResult);
              console.log('T', this.search_typologies_result);
              console.log('R', this.search_rest_name_result);
              console.log('P', this.search_plate_name_result);
            })
            .catch(function (error) {
              console.log(error);
            })
        },

        changeRestResult: function(){
          this.restaurants = this.search_typologies_result;
          this.displayPlates = 0;
          this.displayRestaurants = 1;
          this.$forceUpdate();
          this.closeSearchBar();
        },

        closeSearchBar: function(){
          this.result_tendina = 0;
          this.searchInput = "";
        },

        showRestByName: function(){
          queries = this.oldSearchInput;
          axios.get('/getallrestbyname/' + queries, {
            params: {
            }
            })
            .then((response) => {
              console.log('allbyname', response.data);
              this.restaurants = response.data;
              this.displayPlates = 0;
              this.displayRestaurants = 1;
              this.$forceUpdate();
            })
            .catch(function (error) {
              console.log(error);
            })
          this.closeSearchBar();
        },

        showPlatesbyName: function(){
          this.displayRestaurants = 0;
          this.displayPlates = 1;
          this.closeSearchBar();
          queries = this.oldSearchInput;
          axios.get('/getallplatebyname/' + queries, {
            params: {
            }
            })
            .then((response) => {
              console.log("all plates ->", response.data);
              this.plates = response.data;
              this.$forceUpdate();
            })
            .catch(function (error) {
              console.log(error);
            })
        },

        pushInCart: function(plate) {
          this.cart.push(plate);
        },

        reset_cart: function() {
          this.cart = [];
          this.cart_new = [];
        },

        get_cart: function() {

          axios.post('http://localhost:8000/keep-cart', {
                    cart: this.cart
                  })
                .then(cart => {

                  if (cart.status === 200) {

                    for(let i=0; i<cart.data.length; i++) {
                      this.order.push(cart.data[i]);
                    }
                  window.location='http://localhost:8000/create/order';
                  }

                })
                .catch(error => {
                  console.log(error);
                });
        },

        plate_final_price: function(price, discount) {
          if (discount > 0) {
            let sconto_euro = (discount * price / 100) / 100;
            price = price / 100;
            return (price - sconto_euro).toFixed(2);
          } else {
            return price / 100;
          }
        },

      },
  });
}

document.addEventListener("DOMContentLoaded", init);
