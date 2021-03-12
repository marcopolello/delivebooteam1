@extends('layouts.order-layout')

@section('content')

  {{-- bug: se ricarico la pagina crea un ordine uguale al precedente con id +1 --}}

  <div class="order-pay-container">

    <div class="cont-marg-left">


          <div id="order-summary">

            <div class="order-summary-box">

              <div class="separate-summary">

                <h1>
                  Ecco un Riepilogo dell'ordine:
                </h1>

              </div>
              <div class="separate-summary">
                <span class="">Nome: </span>
                <span class="">{{$newOrder -> first_name}}</span>
              </div>
              <div class="separate-summary">
                <span class="">Cognome: </span>
                <span class="">{{$newOrder -> last_name}}</span>
              </div>
              <div class="separate-summary">
                <span class="">Indirizzo di consegna: </span>
                <span class="">{{$newOrder -> address}}</span>
              </div>
              <div class="separate-summary">
                <span class="">Email: </span>
                <span class="">{{$newOrder -> email}} </span>
              </div>
              <div class="separate-summary">
                <span class="">Recapito telefonico: </span>
                <span class="">{{$newOrder -> phone}}</span>
              </div>
              <div class="separate-summary">
                <span class="">Totale: </span>
                  <span class="">{{$newOrder -> total_price/100}} €
                </span>
              </div>










              {{-- <h1><a href="{{ route('orders-index')}}">Indietro alla index-new</a></h1> --}}

              {{-- <h1>
              <a href="{{ route('pay')}}">ROTTA PER IL PAGAMENTO</a>
              </h1> --}}

            </div>


            {{-- inizia contenuto braintree (script all'interno del content --}}
            <div class="content pay-box">

              <form method="POST" id="payment-form"
                action="{{ route('checkout', $newOrder -> id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('POST')

                {{-- ricordare che ci sono input nascosti che utente non dovrà modificare --}}

                <section>
                  {{-- <label type="hidden" for="restaurant-email">ristorante a cui ordino:</label> --}}
                  <input type="hidden" type="text" name="restourant-email" value="{{ $restoraunt -> email }}" readonly>
                  {{-- <label for="restaurant-name">nome ristorante:</label> --}}
                  <input type="hidden" type="text" name="restourant-name" value="{{ $restoraunt -> name }}" readonly>
                  {{-- <label for="email">email utente: </label> --}}
                  <input type="hidden" type="text" name="email" value="{{$newOrder -> email}}" readonly>
                  {{-- <label for="name">name utente: </label> --}}
                  <input type="hidden" type="text" name="name" value="{{$newOrder -> first_name}}" readonly>
                  {{-- <label for="last_name">lastname utente: </label> --}}
                  <input type="hidden" type="text" name="last_name" value="{{$newOrder -> last_name}}" readonly>

                  <label id="input-amount" for="amount">
                    {{-- <h2 class="input-label">
                      totale da pagare:
                    </h2> --}}

                    <div class="input-wrapper amount-wrapper">
                      {{-- questo input sarà hidden perché il prezzo da pagare arriverà dal carrello --}}
                      <input type="hidden" id="amount" name="amount" type="tel" min="1" placeholder="Amount"
                      value="{{$newOrder -> total_price/100}}" readonly>
                    </div>
                  </label>

                  <div class="bt-drop-in-wrapper">
                    <div id="bt-dropin"></div>
                  </div>
                </section>



                <input type="hidden" id="nonce" name="payment_method_nonce" type="text" readonly />
                <button id="pay-button" class="button" type="submit"><span>Effettua il Pagamento</span></button>
              </form>


              <script src="https://js.braintreegateway.com/web/dropin/1.26.1/js/dropin.min.js"></script>
              <script src="https://js.braintreegateway.com/web/3.73.1/js/hosted-fields.min.js"></script>
              <script>
                var form = document.querySelector('#payment-form');
                var client_token = "{{ $token }}";

                braintree.dropin.create({
                  authorization: client_token,
                  selector: '#bt-dropin',
                  paypal: {
                    flow: 'vault'
                  }
                }, function (createErr, instance) {
                  if (createErr) {
                    console.log('Create Error', createErr);
                    return;
                  }
                  form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    instance.requestPaymentMethod(function (err, payload) {

                      if (err) {
                        console.log('Request Payment Method Error', err);
                        return;
                      }

                      // Add the nonce to the form and submit
                      document.querySelector('#nonce').value = payload.nonce;
                      form.submit();
                    });
                  });
                });
              </script>

            </div>

          </div>


          <div class="coffee-container">
            <div class="coffee-header">
              <div class="coffee-header__buttons coffee-header__button-one"></div>
              <div class="coffee-header__buttons coffee-header__button-two"></div>
              <div class="coffee-header__display"></div>
              <div class="coffee-header__details"></div>
            </div>
            <div class="coffee-medium">
              <div class="coffe-medium__exit"></div>
              <div class="coffee-medium__arm"></div>
              <div class="coffee-medium__liquid"></div>
              <div class="coffee-medium__smoke coffee-medium__smoke-one"></div>
              <div class="coffee-medium__smoke coffee-medium__smoke-two"></div>
              <div class="coffee-medium__smoke coffee-medium__smoke-three"></div>
              <div class="coffee-medium__smoke coffee-medium__smoke-for"></div>
              <div class="coffee-medium__cup"></div>
            </div>
            <div class="coffee-footer"></div>
          </div>

    </div>

  </div>




@endsection
