@extends('layouts.layout-dashboard')

@section('content')

    <div class="container-dashboard">

        <div class="left-side-dash">
            <div class="img-user">
                @if (Auth::user() -> photo)
                    <img src="{{ asset('/storage/restaurant_icon/' . Auth::user() -> photo) }}" alt="">
                @else
                    <img src="{{ asset('storage/user.svg') }}" alt="">
                @endif
            </div>

            <h1>
                {{ $mail_cut }}
            </h1>

            <form action="{{ route('plates-create') }}">
                <button id="pls-plate" type="submit">
                    <i class="fas fa-plus"></i>
                    Aggiungi un nuovo piatto
                </button>
            </form>



            <div class="buttons-left-dash">
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
                <button>
                    Statistiche ordini
                    <span class="order-color"></span><span class="order-color"></span><span class="order-color"></span><span class="order-color"></span>
                </button>

                <a
                    class="btn btn-danger"
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

        <div class="right-side-dash">
            <div class="header-right-dash">

                {{-- MENU HAMBURGER --}}

                {{-- FINE MENU HAMBURGER --}}

                <h3>Welcome
                    <span>{{ Auth::user() -> name }}!</span>
                </h3>

                <a href="{{ route('index') }}">
                    <img src="{{ asset('storage/img/deliveroo-logo.svg') }}" alt="">
                </a>
            </div>

            {{-- CONTAINER PRINCIPALE DELLE CARD --}}
            <div class="container-card">
                {{-- CARD ORDER--}}
                <div class="card">
                    <h3>Gli ultimi ordini</h3>
                    {{-- LISTA ORDINI NELLA CARD --}}
                    <div class="mini-card">
                        <h5>Pippo Ronaldo</h5>
                        <hr>
                        <div class="price-right">
                            <p>Status: pagato</p>
                            <span>23,65€</span>
                        </div>
                        <p>Cellulare: 3333333</p>
                    </div>
                    <div class="mini-card">
                        <h5>Pippo Ronaldo</h5>
                        <hr>
                        <div class="price-right">
                            <p>Status: pagato</p>
                            <span>23,65€</span>
                        </div>
                        <p>Cellulare: 3333333</p>
                    </div>
                    <div class="mini-card">
                        <h5>Pippo Ronaldo</h5>
                        <hr>
                        <div class="price-right">
                            <p>Status: pagato</p>
                            <span>23,65€</span>
                        </div>
                        <p>Cellulare: 3333333</p>
                    </div>
                </div>
                {{-- CARD STATISTICS --}}
                <div class="card">
                    <h3>Le tue statistiche</h3>
                    <div class="graph-chart-js">
                        <h3>Grafico statistiche</h3>
                    </div>
                </div>
                {{-- CARD FEEDBACK --}}
                <div id="resp-card" class="card">
                    <h3>I tuoi feedback</h3>
                    <div class="percentual-feed">
                        <h1>90%</h1>
                        <h4>positivi</h4>
                    </div>
                </div>
            </div>

            <div class="last-order">
                <h2>
                    I tuoi ultimi 10 ordini
                </h2>

                {{-- CARD ORDINI --}}
                <div class="card-order">
                    <div class='card-relative'>

                        <div class="order-info">
                            <h3>
                                Pippo Ronaldo
                            </h3>
                            <hr>
                            <p>Status: pagato</p>
                            <p>Cellulare: 3333333</p>
                        </div>

                        <div class="right-card-order">
                            <div>
                                23,65 €
                            </div>
                            <div>
                                <button>Apri comanda</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-order">
                    <div class='card-relative'>

                        <div class="order-info">
                            <h3>
                                Pippo Ronaldo
                            </h3>
                            <hr>
                            <p>Status: pagato</p>
                            <p>Cellulare: 3333333</p>
                        </div>

                        <div class="right-card-order">
                            <div>
                                23,65 €
                            </div>
                            <div>
                                <button>Apri comanda</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-order">
                    <div class='card-relative'>

                        <div class="order-info">
                            <h3>
                                Pippo Ronaldo
                            </h3>
                            <hr>
                            <p>Status: pagato</p>
                            <p>Cellulare: 3333333</p>
                        </div>

                        <div class="right-card-order">
                            <div>
                                23,65 €
                            </div>
                            <div>
                                <button>Apri comanda</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- fine card ORDINI --}}

            {{-- <div class="footer-dash">
                <div>
                    <form class="" action="{{ route('orders-index') }}">
                        <button>
                            Visualizza tutti gli ordini
                        </button>
                    </form>

                </div> --}}


            <div>
                <ul>
                    @foreach ($feedbacks as $fb)
                        <li>{{ $fb -> email }}</li> <br>
                        <li>{{ $fb -> rate }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>

@endsection
