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
            <form action="{{ route('feedbacks') }}">
                <button class="btn btn-success" type="submit">
                    Visualizza i feedbacks
                    <span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span><span class="plate-color"></span>
                </button>
            </form>
        </div>
    </div>
  </section>
@endsection