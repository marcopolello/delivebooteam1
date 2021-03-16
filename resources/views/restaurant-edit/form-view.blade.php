@extends('layouts.layout-dashboard')

@section('restaurant-edit')
  <div class="container-restaurant">
    <main class="main-edit-restaurant">

      <form class="user-info" action="{{route('upload-info')}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="sides-flex-edit-restaurant">

          <div class="left-side-edit-restaurant">
            <div class="user-bubble">

              @if ($user -> photo)
                @php
                  $photoUrl = '/storage/restaurant_icon/' . $user -> photo;
                @endphp
              @endif

              @if (Auth::user() -> photo)
              <div class="restaurant-image" style="background-image: url({{asset($photoUrl)}})">
              </div>
              @else
              <div class="restaurant-image" style="background-image: url({{asset('/storage/user.svg')}})">
              </div>
              @endif

              <div class="left-side-edit-restaurant-buttons">

                <input name="photo" type="file">

                <br>
                <a href="{{route('delete-icon')}}" class="btn btn-danger">Rimuovi foto ristorante</a>

              </div>
            </div>
          </div>

          <div class="right-side-edit-restaurant">

            <h1>{{$user -> name}}</h1>

            <h3>{{$user -> email}}</h3>

            @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @endif



              <div class="">
                <label for="phone">Telefono:</label>
                <input type="text" name="phone" value="{{$user -> phone}}" minlength="6" maxlength="30" required>
              </div>

              <div class="">
                <label for="description">Descrizione:</label>
                <textarea name="description" rows="4" cols="50" maxlength="255">
                  {{trim($user -> description)}}
                </textarea>
              </div>

              @php
                $delivery_euro = substr($user -> delivery_cost, 0, strlen($user -> delivery_cost) -2);
                $delivery_cents = substr($user -> delivery_cost, -2);
              @endphp

              <div class="">
                <label for="delivery_cost_euro">Costo di spedizione (euro):</label>
                <input type="number" name="delivery_cost_euro" value="{{$delivery_euro}}" min="0" max="9999" required>
              </div>

              <div class="">
                <label for="delivery_cost_cent">Costo di spedizione (centesimi):</label>
                <input type="number" name="delivery_cost_cent" value="{{$delivery_cents}}" min="0" max="99" required>
              </div>

              <div class="overflow-types">
                <label for="types[]">Le tipologie del tuo ristorante</label>
                  @foreach ($alltypes as $type)
                      <div class="typology-checkbox">
                        <input name='types[]' type="checkbox" value='{{ $type -> id }}'
                        @foreach ($user -> typologies as $type_user)
                            @if ($type -> id == $type_user -> id)
                                checked
                            @endif
                        @endforeach
                        >
                        <span>{{ $type -> typology }}</span>
                      </div>
                  @endforeach

              </div>

              <div class="submit-button">
                <input type="submit" name="" class='btn btn-success' value="Modifica">
              </div>

          </div>
        </form>
    </main>
  </div>

@endsection
