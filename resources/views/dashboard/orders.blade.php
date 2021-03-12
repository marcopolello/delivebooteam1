<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h3>Ordini del ristorante: {{$user -> email}}</h3>

    <h5>Ordini:</h5>
    <ul>
      @if (count($userOrders) > 0)
        @foreach ($userOrders as $order)
          <li>
            <p>{{$order}}</p>
            <a href="{{route('restaurant-comanda', $order -> id)}}">Apri comanda</a>
          </li>
        @endforeach
      @else
          <li>Nessun ordine</li>
      @endif
    </ul>
  </body>
</html>
