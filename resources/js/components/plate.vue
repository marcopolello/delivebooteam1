<!-- Da aggiungere:
fatto: se non diponibile,
fatto: click: apertura dettagli,
fatto: gestire meglio l'img, specie se non quadrate, magari come background img
cut del testo da vue (ok ma non va da responsive) -->

<!-- inserire comunicazione con il carrello -->
<!-- inserire responsive -->

<template>
  <div class="plate_container">

    <div class="plate_text" @click="display_details_method">
      <h2 class="title">{{nome}}</h2>
      <p class="descrizione">{{descrizione_short}}</p>
      <span :class="['prezzo_intero' ,{'prezzo_barrato': this.sconto > 0}]">{{prezzo_euro}}€</span>
      <span v-if="this.sconto > 0" class="prezzo_scontato">{{prezzo_sconto}}€</span>
    </div>

    <div class="plate_img" @click="display_details_method"
      :style="{'background-image':'url(' + url_img +')'}">
      <span v-if="this.sconto > 0" class="sconto">{{sconto}}%</span>
    </div>

    <div v-if="this.disponibile == 0" class="plate_esaurito">
      <p>Esaurito</p>
    </div>

      <!-- Dettagli al click -->
      <div v-show="display_details" class="layover">
        <div class="plate_detail">

          <section class="header">
            <h2 class="title">{{nome}}</h2>
            <div class="close_details" @click="close_details">
              X
            </div>
          </section>

          <section class="show">
            <div class="plate_img" :style="{'background-image':'url(' + url_img +')'}">
            </div>
            <p class="descrizione">{{descrizione}}</p>
            <p>Ingredienti: <br> {{ingredienti}}</p>

            <div class="quantity_pannel">

              <div class="remove_plate" @click="remove_quantity">
                -
              </div>
              <div class="quantity">
                <span>{{ quantity }}</span>
              </div>
              <div class="add_plate" @click="add_quantity">
                +
              </div>

            </div>
          </section>

          <section class="total">
            <div class="button button-light cancel" @click="close_details">
              <span>Cancella</span>
            </div>

            <div 
              @click="pushItemInCart()"
              class="button button-strong">
              <strong>TOTALE {{ total_price }}€</strong>
            </div>

          </section>
        </div>
      </div>
  </div>
</template>

<script>
    export default {
      data: function() {
       return {
          'nome': this.plate_data.plate_name,
          'ingredienti': this.plate_data.ingredients,
          'descrizione': this.plate_data.description,
          'prezzo_cent': this.plate_data.price,
          'sconto': this.plate_data.discount,
          'disponibile': this.plate_data.availability,
          'immagine': this.plate_data.img,
          'plate_id': this.plate_data.id,
          // flags
          'display_details': false,
          //aggiungi al carrello
          'quantity': 1,
        };
      },

      computed: {

        descrizione_short: function(){
          let descrizione = this.descrizione;
          if (descrizione.length > 100) {
            descrizione = descrizione.slice(0,97);
            descrizione += '...';
          }
          // console.log(descrizione);
          return descrizione;
        },

        prezzo_euro: function() {
          return (this.prezzo_cent / 100).toFixed(2);
        },

        prezzo_sconto: function() {
          if (this.sconto > 0) {
            let sconto_euro = (this.sconto * this.prezzo_euro / 100).toFixed(2);
            return (this.prezzo_euro - sconto_euro).toFixed(2);
          } else {
            return "Prezzo intero";
          }
        },



        total_price: function(){
          let total_price;
          if (this.sconto > 0) {
            total_price = this.prezzo_sconto;
          } else {
            total_price = this.prezzo_euro;
          }
          return (total_price * this.quantity).toFixed(2);
        },

        url_img: function() {
          return '/storage/plates/' + this.immagine;
        }

      },

      mounted() {
          console.log('Plate mounted');
          // console.log(this.plate_data);
      },

      props: {
        plate_data: Object
      },

      watch: {
      },

      methods: {
        add_quantity: function(){
          this.quantity++;
        },

        remove_quantity: function(){
          if (this.quantity > 1) {
            this.quantity--;
          }
        },

        close_details: function(){
          this.quantity = 1;
          this.display_details = false;
        },

        display_details_method: function() {
          if (this.disponibile) {
            this.display_details = true;
          }
        },

        pushItemInCart: function() {
          
          let plate = {};
          
          for (let i = 0; i < this.quantity; i++) {
            
            plate = {
              "plate_id": this.plate_id,
              "plate_price" : this.prezzo_sconto,
              "plate_name": this.nome, 
            };

            this.$emit('carrello', plate);
          }          
        }, 
      },
    }
</script>
