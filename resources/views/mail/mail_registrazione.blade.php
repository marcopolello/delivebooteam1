<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Mail-Register</title>
  </head>
  <style media="screen">
    body{
      background-color: blue;
    }
  </style>
  <body>

    <h1>Gentile {{ $user -> name }},</h1>

    <p>
      il tuo account Deliveboo è stato creato. Ti ricordiamo la email che hai scelto in fase di registrazione: <br>
      <h4>{{$user -> email}}</h4>
      Ora che sei registrato, potrai amministrare la tua attività nella tua
      home personale. <br>
      Un piccolo recapito degli altri dati con cui ti sei registrato: <br>
      - {{$user -> address}} <br>
      - {{$user -> phone}} <br>
      - {{$user -> piva}} <br>
      - {{$user -> delivery_cost}} <br>


      Cordiali saluti, <br>
      Team 1
    </p>




  </body>
</html>
