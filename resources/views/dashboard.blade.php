@extends('layouts.layout-dashboard')

@section('content')

    <div class="container-dashboard">

        <div class="left-side-dash">
            @if (Auth::user() -> photo)
                <div class="img-user" style="background-image: url({{ asset('/storage/restaurant_icon/' . Auth::user() -> photo) }})">
                </div>
            @else
                <div class="img-user" style="background-image: url({{ asset('storage/user.svg') }})">
                </div>
            @endif
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

                <h3>Benvenuto/a
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
                    @if (!empty($orders_3))
                        @foreach ($orders_3 as $item_3)
                            <div class="mini-card">
                                <h5>{{$item_3 -> first_name}} {{$item_3 -> last_name}}</h5>
                                <hr>
                                <div class="price-right">
                                    @if ($item_3 -> payment_state)
                                        <p>Ordine pagato</p>
                                    @else
                                        <p>Ordine da pagare</p>
                                    @endif 
                                    <span>{{$item_3 -> total_price / 100}} €</span>
                                </div>
                                <p>Cellulare: {{$item_3 -> phone}}</p>
                            </div>      
                        @endforeach
                    @else
                        <div class="mini-card">
                            <h3>Non hai ancora ordini!</h3>
                        </div> 
                    @endif
                </div>
                {{-- CARD STATISTICS --}}
                <div class="card">
                    <h3>Le tue statistiche</h3>
                    <div class="graph-chart-js">
                        <div>
                            {!! $chartjsDashboard->render() !!}
                        </div>
                    </div>
                </div>
                {{-- CARD FEEDBACK --}}
                <div id="resp-card" class="card">
                    <h3>I tuoi feedback</h3>
                    <div class="graph-chart-js">
                        <div>
                            {!! $chartjsFeedbacks->render() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-card">
                <div class="card-feed">
                    @if (!empty($smallFeedbacks))
                        @foreach ($smallFeedbacks as $fb)
                            <div class="mini-card-feed">
                                <div class="feedbacks-cards">
                                    <div>
                                        <h4>{{ $fb -> name }}</h4>
                                        <br>
                                        <p>{{ $fb -> email }}</p>
                                        <br>
                                        <label>Comment:
                                            <h2>{{ $fb -> comment }}</h2>
                                        </label>

                                    </div>
                                    <div>
                                        <h2>Rate: {{ $fb -> rate }}</h2>
                                    </div>
                                </div>
                            </div>        
                        @endforeach                        
                    @else
                        <h2>Nessun feedback al momento!</h2>
                    @endif
                </div>
            </div>

        </div>

    </div>

@endsection
