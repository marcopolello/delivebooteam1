<div id="search-bar" :class="{ 'active' : result_tendina}">

  <i class="fas fa-search search-icon"></i>
  <input class="search" type="text" placeholder="Piatti, ristoranti o tipi di cucina" v-on:keyup.enter="startResearch($event.target.value)" v-model="searchInput">
  <div class="close" @click="closeSearchBar()">
    <i class="fas fa-times"></i>
  </div>

  <div class="results" v-if="result_tendina">
    <div class="category" v-if="!no_result && !research_error && research_category">
      <p class="section_title">Categorie</p>
      <div @click="changeRestResult()" class="category_result">
        <i class="fas fa-search"></i>
        <span>@{{oldSearchInput}}</span>
        <span>(@{{search_typologies_result.length}})</span>
      </div>
    </div>

    <div class="restaurants" v-if="!no_result && !research_error && research_restaurants">
      <p class="section_title">Ristoranti</p>
      <a :href="'/restaurant/' + restaurant.id" v-for="restaurant in search_rest_name_result">
        <div class="rest_result">

          <div v-if="restaurant.photo != null" class="img" :style="{'background-image':'url(' + '/storage/restaurant_icon/' + restaurant.photo + ')'}"></div>
          <div v-else class="img" :style="{'background-image':'url(' + '/storage/placeholder.svg' + ')'}"></div>

          <div class="description">
            <h1 class="rest_name">@{{restaurant.name}}</h1>
            <i class="far fa-star"></i>
            <span class="average_rate">@{{restaurant.average_rate}}</span>
            <span class="rate_number">(@{{restaurant.rate_number}})</span>
          </div>

        </div>
      </a>
      <p class="total_results" @click="showRestByName()">@{{searchResult.total_restNames_number}} ristoranti. Vedi tutti.</p>
    </div>

    <div class="plates" v-if="!no_result && !research_error && research_plates">
      <p class="section_title">Piatti</p>
      <a v-for="plate in search_plate_name_result" :href="'/restaurant/' + plate.user_id">
        <div class="plate_result">

          <div v-if="plate.img != null" class="img" :style="{'background-image':'url(' + '/storage/plates/' + plate.img + ')'}"></div>
          <div v-else class="img" :style="{'background-image':'url(' + '/storage/placeholder.svg' + ')'}"></div>

          <div class="description">
            <h1 class="plate_name">@{{plate.plate_name}}</h1>
            <span class="plate_price">@{{plate_final_price(plate.price, plate.discount)}}€</span>
          </div>

        </div>
      </a>
      <p class="total_results" @click="showPlatesbyName()">Mostra tutti i piatti</p>
    </div>

    <div class="no-results info" v-show="no_result">
      <p>Nessun risultato</p>
    </div>

    <div class="error info" v-show="research_error">
      <p>Nessun risultato: prova ad inserire parole più lunghe.</p>
    </div>

    <div class="loading info" v-show="loading">
      <p>Ricerca in corso...</p>
    </div>

  </div>
</div>
