<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Ordine id: {{$order -> id}}</h1>

    <h3>Plates:</h3>
    <ul>
      @foreach ($order -> plates as $plate)
        <li>{{$plate}}</li>
      @endforeach
    </ul>
  </body>
</html>
