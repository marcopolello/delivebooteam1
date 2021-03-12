@extends('layouts.layout-dashboard')

@section('dashboard-orders')
  <section class="section-order">
      <h3>RIEPILOGO DEI TUOI ORDINI RICEVUTI
          <span> {{ $mail_cut }}</span>
      </h3>

      <div class="button-dashboard">
        <form class="" action="{{ route('dashboard') }}">
            <button type="submit">Torna alla dashboard</button>
        </form>
      </div>

      <section class="order-card">
        @if (count($userOrders) > 0)
          @foreach ($userOrders as $order)
              <div class="block-order">
                  <h3>Order ID:
                      <span>{{ $order -> id }}</span>
                  </h3>
                    <p>Nome:
                      <span>{{ $order -> first_name }}</span>
                    </p>
                    <p>Cognome:
                      <span>{{ $order -> last_name }}</span>
                    </p>
                    <p>Email:
                      <span>{{ $order -> email }}</span>
                    </p>
                    <p>Cellulare:
                      <span>{{ $order -> phone }}</span>
                    </p>
                    <p>Commenti:
                      <span>{{ $order -> comment }}</span>
                    </p>
                    <p>Indirizzo:
                      <span>{{ $order -> address }}</span>
                    </p>
                    <p>Stato pagamento:
                      @if ($order -> payment_state)
                        <span>Pagato</span>
                      @else
                        <span>Non pagato</span>
                      @endif
                    </p>
                    <p>Prezzo totale:
                      <span>{{ $order -> total_price / 100}}€</span>
                    </p>
                    <p>Data ordine:
                      <span>{{ $order -> created_at }}</span>
                    </p>
                    <form class="apri-comanda" action="{{ route('restaurant-comanda', $order -> id) }}">
                      <button type="submit">Apri comanda</button>
                    </form>
                  </div>
                @endforeach
              @else
                <h2>NON HAI NESSUN ORDINE!</h2>
              @endif
      </section>
  </section>
@endsection
