<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('/css/app.css')}}">
        <script src="{{asset('/js/app.js')}}" ></script>
    </head>
    <body>
      <h1>Piatti</h1>
      @php
        // var_dump($plate_data);die();
      @endphp

      <a href="{{route('dashboard')}}">Vai alla Dashboard</a>

      <div id="app">
        @foreach ($plate_data as $plate)
          <plate
            :plate_data='{{$plate}}'
          ></plate>
        @endforeach

      </div>
    </body>
</html>
