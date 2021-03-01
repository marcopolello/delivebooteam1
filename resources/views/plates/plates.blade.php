<section>
  <h4>Benvenuto: {{$user -> name}}</h4>
  <h3>Lista di tutti i piatti</h3>

  <ul>
    @foreach ($user -> plates as $plate)
      <li>
        <div class="dashboard_plate">

          <div class="column">
              <p>Nome piatto:</p>
              <p>{{$plate -> plate_name}}</p>
          </div>

          <div class="column">
              <p>Ingredienti:</p>
              <p>{{$plate -> ingredients}}</p>
          </div>

          <div class="column">
              <p>Descrizione:</p>
              <p>{{$plate -> description}}</p>
          </div>

          <div class="column">
              <p>Prezzo</p>
              <p>{{($plate -> price) / 100}}€</p>
          </div>

          <div class="column">
              <p>Visibile</p>
              @if ($plate -> visible)
                <input type="checkbox" disabled="disabled" checked>
              @else
                <input type="checkbox" disabled="disabled">
              @endif
          </div>

          <div class="column">
              <p>Sconto %</p>
              <p>{{$plate -> discount}}%</p>
          </div>

          <div class="column">
            <p>Categoria</p>
            <p>{{$plate -> category -> category}}</p>
        </div>

          <div class="column">
              <p>Disponibile</p>
              @if ($plate -> availability)
                <input type="checkbox" disabled="disabled" checked>
              @else
                <input type="checkbox" disabled="disabled">
              @endif
          </div>

          <div class="column">
              <p>Immagine</p>
              <p>ancora in lavorazione</p>
          </div>

          <div class="column">
            <form action="{{ route('plates-edit', $plate -> id) }}">
              <button type="submit">
                  Modifica Piatto
              </button>
          </form>
          </div>

        </div>

      </li>
    @endforeach
  </ul>
</section>
