@extends('layouts.layout-welcome')

@section('content')

    {{-- MAIN --}}
    <main>

        <div class="container">

            <slider></slider>

            {{-- lista ristoranti --}}
          <section v-if="displayRestaurants">
              <h1>Restaurants</h1>

              <div class="restaurants">

                <div  v-for="restaurant in restaurants" :key="restaurant.id">
                    {{-- <p>@{{restaurant}}</p> --}}
                    <restaurant
                      :restaurant_data="restaurant"
                    ></restaurant>
                </div>

              </div>
          </section>

          <section v-if="displayPlates">
            <h1>Plates</h1>

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

    {{-- FOOTER --}}
    <footer>
        <div class="container">
            <nav>
                <ul>
                    <li>Scopri deliveroo</li>
                    <li><a href="#">asdfghjkl</a></li>
                    <li><a href="#">asdfghjkl</a></li>
                    <li><a href="#">asdfghjkl</a></li>
                </ul>

                <ul>
                    <li>FAQ</li>
                    <li><a href="#">asdfghjkl</a></li>
                    <li><a href="#">asdfghjkl</a></li>
                    <li><a href="#">asdfghjkl</a></li>
                </ul>

                <ul>
                    <li>Aiuto</li>
                    <li><a href="#">asdfghjkl</a></li>
                    <li><a href="#">asdfghjkl</a></li>
                    <li><a href="#">asdfghjkl</a></li>
                </ul>

            </nav>

            <div class="copyright">copyright</div>
        </div>
    </footer>
@endsection
