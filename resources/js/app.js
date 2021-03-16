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
         // console.log("App montata!");
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

          //ham flag
          showHam: false,
      },
      computed: {

        cart_new: function() {

          let newCart = [];
          this.cart.forEach((plate, i) => {
            //conto dei piatti uguali
            let counter = 0;
            this.cart.forEach((plate_confronto, i) => {

                if (plate.plate_id == plate_confronto.plate_id) {
                  counter++;
                }
            });
            if (!newCart.some(plate_new_cart => plate_new_cart.plate_id == plate.plate_id)) {
              newCart.push(
                {
                  "plate_id": plate.plate_id,
                  "original_price": plate.original_price,
                  "plate_price": (parseFloat(counter) * parseFloat(plate.original_price)).toFixed(2),
                  "plate_name": plate.plate_name,
                  "delivery_cost": plate.delivery_cost,
                  "quantity": counter,
                }
              );
            }

          });

          return newCart;
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

        openHam: function() {
          this.showHam = true;
          $("body").addClass("scroll-hide");
        },

        closeHam: function() {
          this.showHam = false;
          $("body").removeClass("scroll-hide");
        },

        getRestaurantsInit: function(){
          axios.get('/getrestaurantsinit', {
            params: {
            }
            })
            .then((response) => {
              // console.log('Primi ristoranti casuali: ', response.data.restaurants);
              this.restaurants = response.data.restaurants;
            })
            .catch(function (error) {
              console.log(error);
            })
        },

        startResearch: function(queries){
          // console.log(queries);
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
                // console.log(response.data.error);
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

              // console.log('ALL', this.searchResult);
              // console.log('T', this.search_typologies_result);
              // console.log('R', this.search_rest_name_result);
              // console.log('P', this.search_plate_name_result);
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

        startResearchSlider: function(query){
          // console.log(query);
          this.oldSearchInput = query;
          this.no_result = 0;
          this.research_error = 0;
          this.research_category = 0;
          axios.get('/search/' + query, {
            params: {
            }
            })
            .then((response) => {
              this.searchResult = response.data;
              this.$forceUpdate();
              if (response.data.error) {
                this.research_error = 1;
              } else if (
                response.data.typology_resoult.length === 0
              ) {
                this.no_result = 1;
              } else {
                if (this.searchResult.typology_resoult.length != 0) {
                  this.research_category = 1;
                  this.changeRestResultSlider();
                }
              }
            })
            .catch(function (error) {
              console.log(error);
            })
        },

        changeRestResultSlider: function() {
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
              // console.log('allbyname', response.data);
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
              // console.log("all plates ->", response.data);
              this.plates = response.data;
              this.$forceUpdate();
            })
            .catch(function (error) {
              console.log(error);
            })
        },

        pushInCart: function(plate) {
          this.cart.push(plate);
          // console.log(plate);
          this.delivery_cost = plate.delivery_cost;
        },

        reset_cart: function() {
          this.cart = [];
          this.cart_new = [];
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

        remove_plate: function(plate){

          let plate_index = -1;
          this.cart.forEach((item, i) => {
            if (item.plate_id == plate.plate_id) {
              plate_index = i;
            }
          });
          if (plate_index > -1) {
            this.$delete(this.cart, plate_index);
          }
          // console.log(this.cart_new);
          this.$forceUpdate();
        },

        add_plate: function(plate){
          // console.log(plate);
          let newPlate = {
            "plate_id": plate.plate_id,
            "original_price": plate.original_price,
            "plate_price": plate.original_price,
            "plate_name": plate.plate_name,
            "delivery_cost": plate.delivery_cost,
          };
          // console.log(newPlate);
          this.cart.push(newPlate);
          this.$forceUpdate();
        },

      },
  });

  $(".alph_order .fas.fa-caret-up").click(function() {
    // console.log("ordina alfabeticamente Z-A");
    $(".alph_order .fas.fa-caret-up").addClass("my-active");
    $(".alph_order .fas.fa-caret-up").toggleClass("my-inactive");

    $(".alph_order .fa-caret-down").addClass("my-active");
    $(".alph_order .fa-caret-down").toggleClass("my-inactive");

    $(".typ_order .fas.fa-caret-up").removeClass("my-active");
    $(".typ_order .fas.fa-caret-down").removeClass("my-active");

    $('.card-plate').sort(function (b, a) {
      let contentA = $(a).find(".plate_name").text();
      let contentB = $(b).find(".plate_name").text();
      return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
   }).appendTo(".dashboard_plate");

  });

  $(".alph_order .fas.fa-caret-down").click(function() {
    // console.log("ordina alfabeticamente A-Z");
    $(".alph_order .fas.fa-caret-up").addClass("my-active");
    $(".alph_order .fas.fa-caret-up").toggleClass("my-inactive");

    $(".alph_order .fa-caret-down").addClass("my-active");
    $(".alph_order .fa-caret-down").toggleClass("my-inactive");

    $(".typ_order .fas.fa-caret-up").removeClass("my-active");
    $(".typ_order .fas.fa-caret-down").removeClass("my-active");

    $('.card-plate').sort(function (a, b) {
      let contentA = $(a).find(".plate_name").text();
      let contentB = $(b).find(".plate_name").text();
      return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
   }).appendTo(".dashboard_plate");
  });

  $(".typ_order .fas.fa-caret-up").click(function() {
    // console.log("ordina categorie Z-A");
    $(".typ_order .fas.fa-caret-up").addClass("my-active");
    $(".typ_order .fas.fa-caret-up").toggleClass("my-inactive");

    $(".typ_order .fa-caret-down").addClass("my-active");
    $(".typ_order .fa-caret-down").toggleClass("my-inactive");

    $(".alph_order .fas.fa-caret-up").removeClass("my-active");
    $(".alph_order .fas.fa-caret-down").removeClass("my-active");

    $('.card-plate').sort(function (b, a) {
      let contentA = $(a).find(".category_name").text();
      let contentB = $(b).find(".category_name").text();
      return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
   }).appendTo(".dashboard_plate");

  });

  $(".typ_order .fas.fa-caret-down").click(function() {
    // console.log("ordina categorie A-Z");
    $(".typ_order .fas.fa-caret-up").addClass("my-active");
    $(".typ_order .fas.fa-caret-up").toggleClass("my-inactive");

    $(".typ_order .fa-caret-down").addClass("my-active");
    $(".typ_order .fa-caret-down").toggleClass("my-inactive");

    $(".alph_order .fas.fa-caret-up").removeClass("my-active");
    $(".alph_order .fas.fa-caret-down").removeClass("my-active");

    $('.card-plate').sort(function (a, b) {
      let contentA = $(a).find(".category_name").text();
      let contentB = $(b).find(".category_name").text();
      return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
   }).appendTo(".dashboard_plate");

  });

  //DASH ham
  $(".header-dashboard-responsive svg").click(function() {
     $(".container-dashboard .left-side-dash").addClass("myactive");
     $(".container-dashboard .right-side-dash").addClass("disabled");
  });

  $(".left-side-dash .close-dash-menu").click(function() {
     $(".container-dashboard .left-side-dash").removeClass("myactive");
     $(".container-dashboard .right-side-dash").removeClass("disabled");
  });
}

document.addEventListener("DOMContentLoaded", init);
