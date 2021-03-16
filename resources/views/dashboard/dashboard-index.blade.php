@extends('layouts.layout-dashboard')

@section('dashboard-home')

  <section class="dashboard-index">
    <div class="header-right-dash">

        <h3>Benvenuto/a
            <span>{{ Auth::user() -> name }}!</span>
        </h3>
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
                        <a class="fake-link" href='{{ route('restaurant-comanda', $item_3 -> id) }}'>
                            <h5>
                            {{$item_3 -> first_name}} {{$item_3 -> last_name}}
                        </h5> 
                        <span></span>
                        </a>
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
        <div class="card resp-card">
            <h3>Le tue statistiche</h3>
            <div class="graph-chart-js">
                {!! $chartjsDashboard->render() !!}
            </div>
            <span></span>
        </div>
        {{-- CARD FEEDBACK --}}
        <div class="card resp-card">
            <h3>I tuoi feedback</h3>
            <div class="graph-chart-js">
                {!! $chartjsFeedbacks->render() !!}
            </div>
            <form action="{{ route('feedbacks') }}">
                <button class="btn btn-outline-info btn-sm" type="submit">
                    Visualizza i feedbacks
                    <span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span>
                </button>
            </form>
        </div>
    </div>

    <div class="cash-cards">

        <div class="sub-cash">
            <h4>
                Ordini nelle ultime 24 ore:
            </h4>
                @php
                    $tot_orders_24 = 0;
                    if(!empty($total_24h)) {
                        foreach ($total_24h as $ord_24) {
                            $tot_orders_24++;
                        }
                    } else {
                        $tot_orders_24 = 'Nessun ordine';
                    }
                @endphp 
            <h2>
                {{$tot_orders_24}}
            </h2>
            <h4>
                Fatturato: 
            </h4>
                @php
                    $total_euro24 = 0;
                    if(!empty($total_24h)) {
                        foreach ($total_24h as $ord_24) {
                            $total_euro24 += $ord_24 -> total_price;
                        }
                        $total_euro24 = $total_euro24 / 100;
                    } else {
                        $total_euro24 = 0;
                    }
                @endphp
                <h2>
                    {{$total_euro24}} €
                </h2>
        </div>

        <div class="sub-cash">
            <h4>
                Ordini nell'ultimo mese: 
            </h4>
                @php
                    $tot_orders_1m = 0;
                    if(!empty($total_1month)) {
                        foreach ($total_1month as $ord_24) {
                            $tot_orders_1m++;
                        }
                    } else {
                        $tot_orders_1m = 'Nessun ordine';
                    }
                @endphp
            <h2>
                {{$tot_orders_1m}}
            </h2>
            <h4>
                Fatturato: 
            </h4>
                @php
                    $total_euro_1m = 0;
                    if(!empty($total_1month)) {
                        foreach ($total_1month as $ord_1m) {
                            $total_euro_1m += $ord_1m -> total_price;
                        }
                        $total_euro_1m = $total_euro_1m / 100;
                    } else {
                        $total_euro_1m = 0;
                    }
                @endphp
            <h2>
                {{$total_euro_1m}} €
            </h2>
        </div>

    </div>
  </section>
@endsection