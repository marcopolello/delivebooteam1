<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  </head>
  <body>
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
                  <h4>Dashboard</h4>
                  <form action="{{ route('restaurant-edit') }}">
                      <button class="btn btn-success" type="submit">
                          Modifica il tuo profilo
                          <span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span>
                      </button>
                  </form>

                  <form action="{{ route('plates-index') }}">
                      <button class="btn btn-success" type="submit">
                          Visualizza i tuoi piatti
                          <span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span>
                      </button>
                  </form>

                  <form class="" action="{{ route('restaurant-order') }}">
                      <button>
                          Visualizza i tuoi ordini
                          <span class="order-color"></span><span class="order-color"></span><span class="order-color"></span><span class="order-color"></span>
                      </button>
                  </form>
                  <form class="" action="{{ route('stats') }}">
                      <button
                          @if (empty($orders_3))
                              disabled
                          @endif
                      >
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
          @include('components.header-no-search')
          @include('components.header-dashboard-responsive')
          <section class="dashboard-content">
            @yield('dashboard-home')
            @yield('create-plate')
          </section>
        </div>

    </div>
  </body>
</html>
