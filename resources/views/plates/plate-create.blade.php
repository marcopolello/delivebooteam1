<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <title>Crea piatto</title>
</head>
<body>
    <header class="header-plate">
        <h1>
            Crea un nuovo piatto
        </h1>
        <a href="{{ route('index') }}">
            <img src="{{ asset('storage/img/deliveroo-logo.svg') }}" alt="">
        </a>
    </header>

    <section class="form-block">
        <img src="{{ asset('storage/img/restaurants-dash.png') }}" alt="">
        <form action="{{ route('plates-store') }}" method="POST" enctype="multipart/form-data">

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

            <h4>Compila il form qui per aggiungere il tuo nuovo piatto</h4>
            <h6>* I campi contrassegnati sono obbligatori</h6>

            <div class="textbox">
                <label class="required" for="plate_name">Nome piatto:</label>
                <input name='plate_name' type="text" placeholder="Nome" required maxlength="30">
            </div>

            <div class="textbox">
                <label class="required" for="ingredients">Ingredienti:</label>
                <input name='ingredients' type="textbox" placeholder="Ingredienti" required minlength="2" maxlength="2000">
            </div>

            <div class="textbox">
                <label for="description">Descrizione:</label>
                {{-- <input name='description' type="text" minlength="2" maxlength="255"> --}}
                <textarea name='description' rows="3" cols="80" minlength="2" maxlength="255"></textarea>
            </div>

            <div class="textbox">
                <label class="required" for="price_euro">Prezzo in €:</label>
                <input name='price_euro' type="number" placeholder="Prezzo in Euro" min="0" max="9999">
            </div>

            <div class="textbox">
                <label class="required" for="price_cents">Prezzo in CENTESIMI:</label>
                <input name='price_cents' type="number" placeholder="Prezzo in Centesimi" min="0" max="99">
            </div>

            <div class="text-checkbox">
                <label for="visible">Visibile:</label>
                <input name='visible' value="1" type="checkbox">
            </div>

            <div class="text-checkbox">
                <label for="availability">Disponibile:</label>
                <input name='availability' value="1" type="checkbox">
            </div>

            <div class="textbox-discount">
                <label class="required" for="discount">Sconto in percentuale:</label>
                <input name='discount' type="number" required min="0" max="100">
            </div>

            <span>Categoria del piatto:</span>
            <select name="category_id">
                @foreach ($categories as $cat)

                    <option value="{{ $cat -> id }}">
                        {{ $cat -> category }}
                    </option>

                @endforeach

            </select>

            <div class="img-box">
                <label for="img">Foto del piatto</label>
                <input name='img' type="file">
            </div>

            <div class="button-save">
                <input type="submit" value="Salva">
            </div>
        </form>
    </section>
</body>
</html>
