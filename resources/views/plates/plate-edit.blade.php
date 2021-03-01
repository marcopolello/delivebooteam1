<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Plate</title>
</head>
<body>

    <h2>
        Edit plate: {{$plate -> plate_name}}
    </h2>
    
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

        <label for="plate_name" >Nome piatto</label>
        <input name='plate_name' value="{{$plate -> plate_name}}" type="text">
        <br>

        <label for="ingredients">Ingredienti:</label>
        <input name='ingredients' value="{{$plate -> ingredients}}" type="textbox">
        <br>

        <label for="description">Descrizione:</label>
        <input name='description' value="{{$plate -> description}}" type="text">
        <br>

        @php
            $price_euro = substr($plate -> price, 0, strlen($plate -> price) -2);
            $price_cents = substr($plate -> price, -2);
        @endphp

        <label for="price_euro">Prezzo (EURO):</label>
        <input name='price_euro' value="{{$price_euro}}" type="number">

        <label for="price_cents">Prezzo (CENTESIMI):</label>
        <input name='price_cents' value="{{$price_cents}}" type="number">

        <br>

        <label for="visible">Visibile:</label>
        <input name='visible' value="1" type="checkbox"
        @if ($plate -> visible)
            checked
        @endif
        >
        <br>

        <label for="availability">Disponibile:</label>
        <input name='availability' value="1" type="checkbox"
        @if ($plate -> availability)
            checked
        @endif
        >
        <br>

        <label for="discount">Sconto in percentuale:</label>
        <input name='discount' value="{{$plate -> discount}}" type="number">
        <br>

        <select name="category_id">

            <option value="null">-</option>

            @foreach ($categories as $cat)

                @if ($cat -> category != 'cancellato')
                    <option value="{{ $cat -> id }}"
                        @if ($plate -> category -> id == $cat -> id)
                            selected
                        @endif
                    >
                        {{ $cat -> category }} 
                    </option>
                @endif

            @endforeach
            
        </select>
        <br>

        @if ($plate -> img)
          @php
            $photoUrl = '/storage/plates/' . $plate -> img;
          @endphp
          <img class="propic-user" src="{{asset($photoUrl)}}" alt="">
        @endif

        <label for="img">Photo</label>
        <input name='img' type="file">

        <br>
        
        <input type="submit" value="Update">

    </form>

</body>
</html>