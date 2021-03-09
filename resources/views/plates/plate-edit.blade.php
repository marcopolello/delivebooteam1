<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Plate</title>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
</head>
<body>

    <header class="header-plate">
        <h1>
            Modifica piatto:
            <span>{{ $plate -> plate_name }}</span>
        </h1>
        <a href="{{ route('index') }}">
            <img src="{{ asset('storage/img/deliveroo-logo.svg') }}" alt="">
        </a>
    </header>

    <section class="form-block">
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

            <div class="textbox">
                <label for="plate_name" >Nome piatto</label>
                <input name='plate_name' value="{{$plate -> plate_name}}" type="text" required maxlength="30">
            </div>

            <div class="textbox">
                <label for="ingredients">Ingredienti:</label>
                <input name='ingredients' value="{{$plate -> ingredients}}" type="textbox" required minlength="2" maxlength="2000">
            </div>

            <div class="textbox">
                <label for="description">Descrizione:</label>
                <textarea name='description' rows="3" cols="80" value="{{$plate -> description}}" type="text" minlength="2" maxlength="255"></textarea>
            </div>

            @php
            $price_euro = substr($plate -> price, 0, strlen($plate -> price) -2);
            $price_cents = substr($plate -> price, -2);
            @endphp

            <div class="textbox">
                <label for="price_euro">Prezzo (EURO):</label>
                <input name='price_euro' value="{{$price_euro}}" type="number" min="0" max="9999">
            </div>

            <div class="textbox">
                <label for="price_cents">Prezzo (CENTESIMI):</label>
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
                <label for="discount">Sconto in percentuale:</label>
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
            </div>

            <div class="button-save">
                <input type="submit" value="Update">
            </div>
        </form>

        <a href="{{ route('plate-delete-img', $plate -> id) }}" class="btn btn-danger">Rimuovi foto piatto</a>

        @if ($plate -> img)
            @php
                $photoUrl = '/storage/plates/' . $plate -> img;
            @endphp
            <h3>Foto del piatto</h3>
            <img class="propic-user" src="{{asset($photoUrl)}}" alt="">
        @endif

    </section>
</body>
</html>
