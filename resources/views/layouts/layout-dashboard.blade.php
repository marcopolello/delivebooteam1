<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deliveboo</title>
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Redressed&display=swap" rel="stylesheet">
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  </head>
  <body>
    @include('components.torna-su')
    <div class="container-dashboard">

        <div class="left-side-dash">

            <div class="close-dash-menu">
                <i class="far fa-window-close"></i>
            </div>

            @if (Auth::user() -> photo)
                <div class="img-user" style="background-image: url({{ asset('/storage/restaurant_icon/' . Auth::user() -> photo) }})">
                </div>
            @else
                <div class="img-user" style="background-image: url({{ asset('storage/user.svg') }})">
                </div>
            @endif
            <h1>
                {{$mail_cut}}
            </h1>

            <form action="{{ route('plates-create') }}">
                <button id="pls-plate" type="submit">
                    <i class="fas fa-plus"></i>
                    Aggiungi un nuovo piatto
                </button>
            </form>



            <div class="buttons-left-dash">
                <div>

                  <form action="{{ route('dashboard') }}">
                    <button class="button-dash" type="submit">
                      Dashboard
                    </button>
                  </form>

                  <form action="{{ route('restaurant-edit') }}">
                      <button class="button-dash" type="submit">
                          Modifica il tuo profilo
                          <span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span>
                      </button>
                  </form>

                  <form action="{{ route('plates-index') }}">
                      <button class="button-dash" type="submit">
                          Visualizza i tuoi piatti
                          <span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span>
                      </button>
                  </form>

                  <form class="" action="{{ route('restaurant-order') }}">
                      <button class="button-dash">
                          Visualizza i tuoi ordini
                          <span class="order-color"></span><span class="order-color"></span><span class="order-color"></span><span class="order-color"></span>
                      </button>
                  </form>
                  <form class="" action="{{ route('stats') }}">
                      <button class="button-dash">
                          Statistiche ordini
                          <span class="order-color"></span><span class="order-color"></span><span class="order-color"></span><span class="order-color"></span>
                      </button>
                  </form>

                </div>

                <div>
                  <a  class="btn btn-danger"
                      href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();"
                      >
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST">
                      @csrf
                  </form>
                </div>
            </div>
        </div>

        <div class="right-side-dash">
          @include('components.header-logo')
          @include('components.header-dashboard-responsive')
          <section class="dashboard-content">
            @yield('dashboard-home')
            @yield('create-plate')
            @yield('feedbacks')
            @yield('plates')
            @yield('plates-edit')
            @yield('dashboard-orders')
            @yield('dashboard-comanda')
            @yield('restaurant-edit')
            @yield('edit-plate')
            @yield('stats')
          </section>
        </div>

    </div>
  </body>
</html>
