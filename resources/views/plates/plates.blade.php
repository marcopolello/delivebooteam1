@extends('layouts.layout-dashboard')

@section('plates')

    <section class="list-plate">
        <h3>Lista di tutti i tuoi piatti</h3>
        <div class="button-dashboard">
            <form class="" action="{{ route('dashboard') }}">
                <button type="submit">Torna alla dashboard</button>
            </form>
        </div>

        <div class="plate_orderer">

        <div class="alph_order">
            <i class="fas fa-caret-up my-active"></i>
            <i class="fas fa-caret-down my-inactive"></i>
            <span>Ordina per nome piatto</span>
        </div>

        <div class="typ_order">
            <i class="fas fa-caret-up"></i>
            <i class="fas fa-caret-down my-inactive"></i>
            <span>Ordina per categorie</span>
        </div>

        </div>

        <div class="dashboard_plate">
            @foreach ($user -> plates -> sortBy('plate_name') as $plate)
                @if ($plate -> destroyed != 1)
                    <div class="card-plate">
                        <div class="list-column">
                            <p>Nome piatto: <span class="plate_name">{{$plate -> plate_name}}</span></p>

                            <p>Ingredienti: {{$plate -> ingredients}}</p>

                            <p>Descrizione: {{$plate -> description}}</p>

                            <p>Prezzo: {{($plate -> price) / 100}}€</p>

                            <p>Sconto: {{$plate -> discount}}%</p>

                            <div class="checked-box">
                                <p>Visibile</p>
                                @if ($plate -> visible)
                                    <input type="checkbox" disabled="disabled" checked>
                                @else
                                    <input type="checkbox" disabled="disabled">
                                @endif
                            </div>

                            <div class="checked-box">
                                <p>Disponibile</p>
                                @if ($plate -> availability)
                                    <input type="checkbox" disabled="disabled" checked>
                                @else
                                    <input type="checkbox" disabled="disabled">
                                @endif
                            </div>


                            <p>Categoria:
                            <span class="category_name">
                                @if ($plate -> category)
                                    {{$plate -> category -> category}}
                                @endif
                            </span>
                            </p>

                        </div>
                        
                        @php
                            $url_img = "/storage/plates/" . $plate -> img;
                        @endphp

                        <div class="plate-right">
                            <div class="column-img"
                            @if ($plate -> img)
                                style="background-image: url({{ $url_img }})"
                            @else
                                style="background-image: url({{ asset('/storage/placeholder.svg') }})"
                            @endif
                            > 
                            </div>

                            <div class="button-plate">
                                <form action="{{ route('plates-edit', $plate -> id) }}">
                                    <button class="edit-button" type="submit">
                                        Modifica piatto
                                    </button>
                                </form>
                                <form action="{{ route('delete-plate', $plate -> id) }}">
                                    <button class="delete-button" type="submit">
                                        Elimina piatto
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

@endsection