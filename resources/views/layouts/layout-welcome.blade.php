<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DeliveBoo</title>

    {{-- style --}}
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">

    {{-- js --}}
    <script src="{{asset('/js/app.js')}}"></script>
</head>
<body>



    <div id="app" class="container-welcome">

      {{-- msg pagamento a scomparsa --}}
      <div v-if="messageVisible">
        @if (session('success_message'))
          <div class="alertpay alert-success">
            {{ session('success_message')}}
          </div>

        @endif

        @if (count($errors) > 0)
          <div class="alertpay alert-danger">
            <ul>
              @foreach ($errors ->all() as $errors)
                <li>{{ $errors }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
      {{-- fine session msg a comparsa del payment --}}

      @include('components.header')
      @yield('content')

    </div>


</body>
</html>
