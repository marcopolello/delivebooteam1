<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/app.css')}} ">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- cdn fontawesome --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Deliveboo</title>
  </head>
  <body>
    @include('components.torna-su')

    @include('components.header-logo')

    @yield('content')
  </body>
</html>
