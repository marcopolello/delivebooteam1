@extends('layouts.layout-dashboard')

@section('edit-plate')
    <section class="form-block">
        <h1>Modifica il tuo piatto</h1>

        <img src="{{ asset('storage/img/restaurants-dash.png') }}" alt="">
        <form action="{{ route('plates-update', $plate -> id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('POST')

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <h6>* I campi contrassegnati sono obbligatori</h6>
            <div class="textbox">
                <label class="required" for="plate_name" >Nome piatto</label>

                <input name='plate_name' value="{{$plate -> plate_name}}" type="text" required maxlength="30">
            </div>

            <div class="textbox">

                <label class="required" for="ingredients">Ingredienti:</label>

                <input name='ingredients' value="{{$plate -> ingredients}}" type="textbox" required minlength="2" maxlength="2000">
            </div>

            <div class="textbox">
                <label for="description">Descrizione:</label>
                <textarea name='description' rows="3" cols="80" value="{{$plate -> description}}" type="text" minlength="2" maxlength="255">{{$plate -> description}}</textarea>
            </div>

            @php
            $price_euro = substr($plate -> price, 0, strlen($plate -> price) -2);
            $price_cents = substr($plate -> price, -2);
            @endphp

            <div class="textbox">

                <label class="required" for="price_euro">Prezzo (EURO):</label>

                <input name='price_euro' value="{{$price_euro}}" type="number" min="0" max="9999">
            </div>

            <div class="textbox">
                <label class="required" for="price_cents">Prezzo (CENTESIMI):</label>
                <input name='price_cents' value="{{$price_cents}}" type="number" min="0" max="99">
            </div>

            <div class="text-checkbox">
                <label for="visible">Visibile:</label>
                <input name='visible' value="1" type="checkbox"
                @if ($plate -> visible)
                    checked
                @endif
                >
            </div>

            <div class="text-checkbox">
                <label for="availability">Disponibile:</label>
                <input name='availability' value="1" type="checkbox"
                @if ($plate -> availability)
                    checked
                @endif
                >
            </div>

            <div class="textbox-discount">
                <label class="required" for="discount">Sconto in percentuale:</label>
                <input name='discount' value="{{$plate -> discount}}" type="number" required min="0" max="100">
            </div>

            <span>Categoria del piatto:</span>
            <select name="category_id">

                @foreach ($categories as $cat)

                    <option value="{{ $cat -> id }}"
                        @if ($plate -> category -> id == $cat -> id)
                            selected
                        @endif
                        >
                        {{ $cat -> category }}
                    </option>

                @endforeach

            </select>

            <div class="img-box">
                <label for="img">Foto</label>
                <input name='img' type="file">
                <br>
                <a href="{{ route('plate-delete-img', $plate -> id) }}" class="btn btn-danger">Rimuovi foto piatto</a>
            </div>

            <div class="img-position">
                @if ($plate -> img)
                    @php
                    $photoUrl = '/storage/plates/' . $plate -> img;
                    @endphp
                    <h3>Immagine del piatto</h3>
                    <img id="img-plate" src="{{ asset($photoUrl) }}" alt="">
                @endif
            </div>

            <div class="button-save">
                <input type="submit" value="Aggiorna">
            </div>
        </form>

    </section>
@endsection
