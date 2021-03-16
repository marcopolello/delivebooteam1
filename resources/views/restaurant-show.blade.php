<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <script src="{{asset('/js/app.js')}}" ></script>

    @php
      // Fa ritornare il voto medio
      $average_vote;
      $vote_number;
      $vote_int;
      $vote_decimal;

      $votes = [];
      foreach ($restaurant -> feedback as $feedback) {
        $votes[] = $feedback-> rate;
      };

      if ($votes) {
        $average_vote = array_sum($votes)/count($votes);
        $average_vote = round ($average_vote , 1);
        $vote_number = count($votes);
        $vote_int = intval($average_vote);
        $vote_decimal = ($average_vote - $vote_int) * 10;
        $vote_decimal = number_format($vote_decimal);
      } else {
        $average_vote = 0;
        $vote_number = 0;
        $vote_int = 0;
        $vote_decimal = 0;
      }
      // dd($average_vote, $vote_int, $vote_decimal * 10);
    @endphp

  </head>
  <body>
    @include('components.torna-su')
    <div id="app" class="rest-show-container">

      <header>
        <div class="container">
          <a href="{{route('index')}}" class="logo">
              <img src="{{asset('storage/img/deliveroo-logo.svg')}}" alt="">
          </a>
          <div class="cart_header">

            <div class="box">

              <svg height="24" width="24" viewBox="0 0 24 24">
                  <path d="M14 15V13H10V15H14ZM15 15H19.1872L19.7172 13H15V15ZM14 12V10H15V12H19.9822L20.5122 10H3.48783L4.01783 12H9V10H10V12H14ZM14 18V16H10V18H14ZM15 18H18.3922L18.9222 16H15V18ZM9 15V13H4.28283L4.81283 15H9ZM9 18V16H5.07783L5.60783 18H9ZM7 8V3H17V8H23L20 20H4L1 8H7ZM9 8H15V5H9V8Z"></path>
              </svg>

              <p class="header_price">@{{total}}€</p>

            </div>

          </div>
        </div>
      </header>


      <div class="rest_info_show">
        <section class="rest_info_left">

          <h2 class="rest_name">{{$restaurant -> name}}</h2>
          <div class="rate-box">
              {{-- stelline piene --}}
              @if ($vote_int > 0)
                @for ($i=0; $i < $vote_int; $i++)
                  <i class="fas fa-star"></i>
                @endfor
              @endif
              {{-- stellina parziale --}}
              @if ($vote_decimal >= 0 && $vote_decimal < 3)
                <i class="far fa-star"></i>
              @endif
              @if ($vote_decimal >= 4 && $vote_decimal < 7 )
                <i class="fas fa-star-half-alt"></i>
              @endif
              @if ($vote_decimal >= 8)
                <i class="fas fa-star"></i>
              @endif
              {{-- stelline rimanenti --}}
              @if (5 - $vote_int > 0)
                @for ($i=0; $i < (5 - $vote_int - 1); $i++)
                  <i class="far fa-star"></i>
                @endfor
              @endif

              <span class="rate">{{$average_vote}}</span>
              <span class="feed_number">({{$vote_number}} valutazioni)</span>
          </div>
          <div class="typology-box">
            @foreach ($restaurant -> typologies as $typ)
              <span>{{$typ -> typology}}</span>
            @endforeach
          </div>
          <div class="more_info">
            <h4 class="more-info-title">Descrizione:</h4>
            @if ($restaurant -> description)
              <p class="rest_desc">{{$restaurant -> description}}</p>
            @else
              <p class="rest_desc">Nessuna descrizione</p>
            @endif
            <p class="rest_phone">Contattaci allo: {{$restaurant -> phone}}</p>
          </div>

        </section>

        <section class="rest_info_right">
          <div class="rest_photo">
            @if ($restaurant -> photo != null)
              <div class="photo" style="background-image: url(/storage/restaurant_icon/{{$restaurant -> photo}})"></div>
            @else
              <div class="photo" style="background-image: url(/storage/placeholder.svg)"></div>
            @endif
          </div>
          <div class="delivery-box">
            <div class="icons-restaurant">
              <i class="fas fa-map-marker-alt"></i>
              <br>
              <i class="fas fa-bicycle"></i>
            </div>
            <div>
              <p class="rest_address"> {{$restaurant -> address}}</p>
              <p class="rest_delivery_cost"> Consegna: {{($restaurant -> delivery_cost / 100)}}€</p>
            </div>
          </div>
        </section>
      </div>

      <main id="rest_show_main">

        <section class="rest_show_left">

          @foreach ($restaurant -> plates as $plate)
            @if ($plate -> visible)
              <plate
                :plate_data='{{$plate}}'
                :delivery_cost='{{$restaurant -> delivery_cost}}'
                @@carrello='pushInCart($event)'
              ></plate>
            @endif
          @endforeach

        </section>

        <section class="rest_show_right">
          <button v-if="cart.length === 0" class="cassa disabled-custom">
            Vai alla cassa
          </button>
          <div class="cart-fixed" v-if='cart.length > 0'>
            <form action="{{ route('get-cart') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('POST')

              <input type="hidden" name='cart' :value='JSON.stringify(cart)' >

              <button type="submit" class="cassa">
                Vai alla cassa
              </button>
            </form>


            <div v-for='item in cart_new' class="item-cart-row">
              <div class="item-cart-row-left">
                <i @click="remove_plate(item)" class="far fa-minus-square change_quantity"></i>
                <span class="item_cart_quant">@{{item.quantity}}</span>
                <i @click="add_plate(item)" class="far fa-plus-square change_quantity"></i>
                <span class="item_cart_name">@{{item.plate_name}}</span>
              </div>
              <div class="item-cart-row-right">
                <span class="item_cart_price">@{{item.plate_price}}€</span>
              </div>
            </div>

            <div class="cart_costs">

              <div class="sub_total">
                <span>Subtotale</span>
                <span>@{{total}}€</span>
              </div>

              <div class="delivery_cost">
                <span>Spese di consegna</span>
                <span>{{$restaurant -> delivery_cost / 100}}€</span>
              </div>

              <button class="reset_cart" @click='reset_cart()'>
                Svuota carrello
              </button>

              <div class="total">
                <span>Totale</span>
                <span>@{{((delivery_cost + (total * 100))/100).toFixed(2)}}€</span>
              </div>

            </div>

          </div>

        </section>


      </main>

    </div>
    @include('components.footer')
  </body>
</html>
