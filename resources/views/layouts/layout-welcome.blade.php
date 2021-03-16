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
    <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">
</head>
<body>
    @include('components.torna-su')

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
      @include('components.header-no-search')

      @yield('content')

    </div>

</body>
</html>
