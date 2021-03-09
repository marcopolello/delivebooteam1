<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <script src="{{asset('/js/app.js')}}" ></script>
  </head>
  <body>
    <h1>ciaone da {{$restaurant -> name}}</h1>
    <h1>costo consegna: {{$restaurant -> delivery_cost / 100}}</h1>

    <div id="app">
      @foreach ($restaurant -> plates as $plate)
        @if ($plate -> visible)
          <plate
            :plate_data='{{$plate}}'

            @@carrello='pushInCart($event)'

          ></plate>
        @endif
      @endforeach

      <div class="cart-fixed" v-if='cart.length > 0'>
        Carrello: <br>

        <div v-for='item in cart_new'>
          @{{item.plate_name}} / x @{{item.quantity}} = @{{item.plate_price}} €
        </div>

        <br>
      
        <div>
          sub total: @{{total}} € <br>
          {{$restaurant -> delivery_cost / 100}} € -> consegna
          <br>

          <button @click='get_cart()'>
            Carrello
          </button>
      
          <br>

          <button @click='reset_cart()'>
            Svuota carrello
          </button>
          

        </div>
      </div>
    

    </div>
  </body>
</html>
