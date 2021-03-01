@extends('layouts.layout-dashboard')

@section('content')

    <div class="container-dashboard">

        <div class="left-side-dash">
            <h3>Welcome</h3>

            <h1>{{ $mail_cut }}</h1>

            <div>
                <hr>
            </div>

            <h3>
                {{ Auth::user()-> name }}
            </h3>

            <div class="buttons-left-dash">

                <form action="{{ route('restaurant-edit') }}">
                    <button type="submit">
                        Modifica Dati
                    </button>
                </form>
                
                <form action="{{ route('plates-index') }}">
                    <button type="submit">
                        Visualizza Piatti
                    </button>
                </form>
                
                <button>
                   Visualizza Ordini
                </button>
                <button>
                    Statistiche Ordini
                </button>
                <button>
                    Logout
                </button>
            </div>
        </div>

        <div class="right-side-dash">
            <div class="header-right-dash">

                <form action="{{ route('restaurant-edit') }}">
                    <button type="submit">
                        Aggiungi un piatto
                    </button>
                </form>

                 <form action="{{ route('index') }}">
                    <button type="submit">
                        Torna alla homepage
                    </button>
                </form>
            </div>

            <div class="last-order">
                <h2>
                    Ultimi ordini ricevuti
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

                {{-- fine card ORDINI --}}

            </div>

            <div class="footer-dash">
                <div>
                    <button>
                        Visualizza tutti gli ordini
                    </button>
                </div>

                <div class="graph-chart-js">
                    grafici
                </div>
            </div>
        </div>

    </div>

@endsection