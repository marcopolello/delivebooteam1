<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Mail-Register</title>
  </head>
  <style media="screen">
    body{
      background-image: url(https://www.datocms-assets.com/15991/1581672962-roothumbnail.png?auto=format);
      background-size: cover;
      background-repeat: no-repeat;
    }
    .mail-contain{
      text-align: justify;
      padding: 0 5%;
      font-family: $font-family-sans-serif;
    }
    ul{
      padding-left: 1%;
    }
  </style>
  <body>

    <div class="mail-back">

      <div class="mail-contain">

        <h1>Gentile {{ $user -> name }},</h1>

        <span>
          <h2>il tuo account Deliveboo è stato creato. </h2>
          <h3>
            Ti ricordiamo la email che hai scelto in fase di registrazione:
          </h3>

          <h2>{{$user -> email}}</h2>

          <h3>
            Ora che sei registrato, potrai amministrare la tua attività nella tua
            home personale.
          </h3>
          <h3>
            Un piccolo recapito degli altri dati con cui ti sei registrato:
          </h3>
          <div>
            <h3>Indirizzo: {{$user -> address}} </h3>
            <h3>Recapito telefonico: {{$user -> phone}} </h3>
            <h3>la tua Partita Iva: {{$user -> piva}} </h3>
            <h3>costo di spedizione impostato: {{$user -> deh3very_cost / 10}} €</h3>
          </div>

          <h2>
            Cordiali saluti, <br>
            Team 1
          </h2>

        </span>

      </div>

    </div>

  </body>
</html>
