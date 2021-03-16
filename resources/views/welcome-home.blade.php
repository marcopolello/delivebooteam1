@extends('layouts.layout-welcome')

@section('content')

  <div class="header-responsive-home">
    @include('components.search-bar')
  </div>

    {{-- MAIN --}}
    <main>

        <div class="main-container-welcome">

            <slider></slider>

            {{-- lista ristoranti --}}
          <section v-if="displayRestaurants">

              <div class="all-restaurants">

                <div class="restaurant" v-for="restaurant in restaurants" :key="restaurant.id">
                    {{-- <p>@{{restaurant}}</p> --}}
                    <restaurant
                      :restaurant_data="restaurant"
                    ></restaurant>
                </div>

              </div>

          </section>

          <section v-if="displayPlates">
        
            <div class="home_plates">

              <div class="home_plate_container" v-for="plate in plates" :key="plate.id">
                  {{-- <div class="home_plate_container"> --}}
                    <a :href="'/restaurant/' + plate.user_id">
                      <section v-if="plate.img != null" class="img" :style="{'background-image':'url(' + '/storage/plates/' + plate.img + ')'}">
                        <p v-show="plate.discount > 0" class="discount">@{{plate.discount}}%</p>
                      </section>
                      <section v-else class="img" :style="{'background-image':'url(' + '/storage/placeholder.svg' + ')'}">
                        <p v-show="plate.discount > 0" class="discount">@{{plate.discount}}%</p>
                      </section>

                      <section class="description">
                        <h2 class="title">@{{plate.plate_name}}</h2>
                        <p class="ingredients">Ingredienti: @{{plate.ingredients}}</p>
                        <p class="plate_description">Descrizione: @{{plate.description}}</p>
                        <span :class="['price' ,{'line': plate.discount > 0}]">@{{plate.price/100}}€</span>
                        <span v-show="plate.discount > 0" class="discounted_price">@{{plate_final_price(plate.price, plate.discount)}}€</span>
                      </section>
                    </a>
                  {{-- </div> --}}
              </div>

            </div>
          </section>

        </div>

    </main>
    @include('components.footer')

@endsection
