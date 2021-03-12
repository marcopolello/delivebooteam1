@extends('layouts.layout-dashboard')

@section('dashboard-comanda')
  <section class="section-comanda">
    <h1>Ordine id: {{$order -> id}}</h1>
    <div class="button-dashboard">
      <form class="" action="{{ route('restaurant-order') }}">
          <button type="submit">Torna agli ordini</button>
      </form>
    </div>

    <ul class="comanda-plates">

      @php
        $plates_ids = [];
        foreach ($order -> plates as $plates_collect) {
          $plates_ids[] = $plates_collect['id'];
        }

        $plates_ids = array_count_values($plates_ids);

        $new_comanda = [];

        foreach ($plates_ids as $key => $id) {

          $new_comanda[$key] = $order -> plates -> firstWhere('id', $key);

          $new_comanda[$key]['quantity'] = $id;
        }
      @endphp

      @foreach ($new_comanda as $plate)

        <li>
          <div class="comanda-plate">

            <h4 class="plate-title">
              {{$plate -> plate_name}} <i class="fas fa-cart-plus"></i> {{$plate -> quantity}}
            </h4>

            @php
              $url_img = "/storage/plates/" . $plate -> img;
            @endphp

            <div class="plate-img-comanda"
              @if ($plate -> img)
                  style="background-image: url({{ $url_img }})"
              @else
                  style="background-image: url({{ asset('/storage/placeholder.svg') }})"
              @endif
            > 
            </div>

            <p class="ingredients">Ingredienti: {{$plate -> ingredients}}</p>
          </div>
        </li>
      @endforeach
    </ul>
  </section>
@endsection
