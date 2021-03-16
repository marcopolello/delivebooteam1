<?php

namespace App\Http\Controllers;
use App\Plate;
use App\User;
use App\Feedback;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Ricerca avviabile solo con almeno una parola inserita lunga 3 caratteri.
// Restituisce messaggio di errore in caso contrario.

// Restituzione tutti i ristoranti
// Restituzione pochi ristoranti casuali per HomePage
// Restituzione ricerca per tipologie
//
// Restituzione 5 piatti per barra ricerca
// Restituzione 5 ristoranti (ricerca nel nome) per barra ricerca
// Restituzione tutti i piatti per home page
// Restituzione tutti i ristoranti (ricerca per nome) per home page

class ResearchController extends Controller
{
    // Restituzione tutti i ristoranti
    public function getAllRestaurants() {
      $restaurants = User::all('users.id','users.name', 'users.address', 'users.phone', 'users.description', 'users.photo', 'users.delivery_cost');

      $restaurants = $this->addRestaurantInfo($restaurants);

      return response() -> json([
        'restaurants' => $restaurants
      ]);
    }

    // Restituzione pochi ristoranti casuali per HomePage
    public function getRestaurantsInit(){
      $restaurants = User::inRandomOrder()->limit(12)
      ->select('users.id','users.name', 'users.address', 'users.phone', 'users.description', 'users.photo', 'users.delivery_cost')
      ->get();

      $restaurants = $this->addRestaurantInfo($restaurants);

      return response() -> json([
        'restaurants' => $restaurants
      ]);
    }

    // Restituisce tipologie, 5 rest name e 5 plate name.
    public function searchTypsRestsPlats($query){
      // Trasformo la query in array
      $queries = explode(" ", $query);
      $originalQueries = $queries;
      $literalResearch = $query;

      // RIMUOVO L'ULTIMA LETTERA DI OGNI QUERY
      foreach ($queries as $index => $q) {
        if (strlen($queries[$index]) > 3) {
          $queries[$index] = substr($queries[$index], 0, -1);
        }
      }
      // Rimuovo le parole di 2 caratter1 (per le congiunzioni)
      foreach ($queries as $index => $word) {
        if (strlen($word) <= 2) {
          unset($queries[$index]);
        }
      }

      if (count($queries) === 0) {
        return response() -> json([
          'error' => 'Parole nel campo di ricerca troppo corte. Almeno 3 caratteri richiesti.'
        ]);
      }

      // 1- ricerca per tipologie
      $responseTypologies = $this->searchTypologies($queries, $literalResearch);
      // 2 cerca nel nome ristorante
      $responseRestNames = $this->searchRestNamesInit($queries);
      // 3 cerca nel nome dei piatti
      $responsePlatesNames = $this->searchPlateNamesInit($originalQueries);

      return response() -> json([
        'typology_resoult' => $responseTypologies,
        'rest_name_resoult' => $responseRestNames,
        'plates_resoult' => $responsePlatesNames,
        'total_plates_number' => $this->getRestAndPlateNumber($queries)['total_plates_names'],
        'total_restNames_number' => $this->getRestAndPlateNumber($queries)['total_rest_names'],
      ]);
    }

    // Restituzione tutti i ristoranti (ricerca per nome) per home page
    public function searchRestNamesAll($query){

      // Trasformo la query in array
      $queries = explode(" ", $query);
      $originalQueries = $queries;

      //RIMUOVO L'ULTIMA LETTERA DI OGNI QUERY
      foreach ($queries as $index => $q) {
        $queries[$index] = substr($queries[$index], 0, -1);
      }
      //Rimuovo le parole di 1 carattere (per le congiunzioni)
      foreach ($queries as $index => $word) {
        if (strlen($word) <= 1) {
          unset($queries[$index]);
        }
      }

      if (count($queries) === 0) {
        return response() -> json([
          'error' => 'Parole nel campo di ricerca troppo corte. Almeno 3 caratteri richiesti.'
        ]);
      }

      $whereClause = [];
      foreach ($queries as $query) {
        $word = '%' . $query . '%';
        $whereClause[] = ['name', 'like', $word];
      }

      $responseRestNames = DB::table('users')
        ->where(
            $whereClause
          )
        ->select('users.id','users.name', 'users.address', 'users.phone', 'users.description', 'users.photo', 'users.delivery_cost')
        ->get();

      $responseRestNames = $this->addRestaurantInfo($responseRestNames);

      return $responseRestNames;
    }

    // Restituzione tutti i piatti per home page
    public function searchPlateNamesAll($query){

      // Trasformo la query in array
      $queries = explode(" ", $query);

      if (count($queries) === 0) {
        return response() -> json([
          'error' => 'Parole nel campo di ricerca troppo corte. Almeno 3 caratteri richiesti.'
        ]);
      }

      $responsePlatesNames = [];

      $whereClause = [];
      foreach ($queries as $query) {
        $plate = '%' . $query . '%';
        $whereClause[] = ['plate_name', 'like', $plate];
      }
      $whereClause[] = ['visible', '=', '1'];
      $whereClause[] = ['destroyed', '=', '0'];
      $whereClause[] = ['availability', '=', '1'];

      $responsePlatesNames = DB::table('plates')
        ->where(
            $whereClause
          )
        ->select('*')
        ->get();

      return $responsePlatesNames;
    }

    private function searchTypologies($queries, $literalResearch){
      //Ricerca letterale
      $responseLiteralTypologies = DB::table('typology_user')
        ->join('users', 'users.id', '=', 'typology_user.user_id')
        ->join('typologies', 'typologies.id', '=', 'typology_user.typology_id')
        ->select('users.id','users.name', 'users.address', 'users.phone', 'users.description', 'users.photo', 'users.delivery_cost')
        ->where('typologies.typology', 'like', $literalResearch)
        ->get();

      $responseLiteralTypologies = $this->addRestaurantInfo($responseLiteralTypologies);

      $whereClause = "";
      foreach ($queries as $query) {
        $typology = "'%" . $query . "%'";
        $whereClause .=  'typologies.typology like ' . $typology . ' OR ';
      }
      $whereClause = substr($whereClause, 0, -4);

      //Ricerca non letterale (scompone le parole)
      $responseTypologies = DB::table('typology_user')
        ->join('users', 'users.id', '=', 'typology_user.user_id')
        ->join('typologies', 'typologies.id', '=', 'typology_user.typology_id')
        ->select('users.id','users.name', 'users.address', 'users.phone', 'users.description', 'users.photo', 'users.delivery_cost')
        ->whereRaw($whereClause)
        ->groupBy('typology_user.user_id')
        ->havingRaw('COUNT(typology_user.user_id) ='. count($queries))
        ->get();

        $responseTypologies = $this->addRestaurantInfo($responseTypologies);

        // Elimino i duplicati
        $allResults = $responseLiteralTypologies->merge($responseTypologies);
        $allResults = $allResults->unique();

        $response = [];
        foreach ($allResults as $key => $res) {
          $response[] = $res;
        }

        return $response;
    }

    private function searchRestNamesInit($queries){
      $whereClause = [];
      foreach ($queries as $query) {
        $word = '%' . $query . '%';
        $whereClause[] = ['name', 'like', $word];
      }

      $responseRestNames = DB::table('users')
        ->where(
            $whereClause
          )
        ->select('users.id','users.name', 'users.address', 'users.phone', 'users.description', 'users.photo', 'users.delivery_cost')
        ->inRandomOrder()
        ->limit(5)
        ->get();

      $responseRestNames = $this->addRestaurantInfo($responseRestNames);

      return $responseRestNames;
    }

    private function searchPlateNamesInit($queries){
      $responsePlatesNames = [];

      $whereClause = [];
      foreach ($queries as $query) {
        $plate = '%' . $query . '%';
        $whereClause[] = ['plate_name', 'like', $plate];
      }
      $whereClause[] = ['visible', '=', '1'];
      $whereClause[] = ['destroyed', '=', '0'];
      $whereClause[] = ['availability', '=', '1'];

      $responsePlatesNames = DB::table('plates')
        ->where(
            $whereClause
          )
        ->select('*')
        ->inRandomOrder()
        ->limit(5)
        ->get();

      return $responsePlatesNames;
    }

    private function addRestaurantInfo($restaurants){

      foreach ($restaurants as $key => $restaurant) {

        $rest = User::findOrFail($restaurant -> id);
        // Fa ritornare il voto medio
        $votes = [];
        foreach ($rest->feedback as $feedback) {
          $votes[] = $feedback-> rate;
        };

        if ($votes) {
          $average = array_sum($votes)/count($votes);
          $average = round ($average , 1);
          $restaurants[$key] -> average_rate = $average;
          $restaurants[$key] -> rate_number = count($votes);
        } else {
          $restaurants[$key] -> average_rate = '0';
          $restaurants[$key] -> rate_number = '0';
        }


        // Fa ritornare le tipologie
        $typologies = [];
        foreach ($rest->typologies as $typology) {
          $typologies[] = $typology -> typology;
        }

        $restaurants[$key]->typologies = $typologies;

      };
      return $restaurants;
    }

    private function getRestAndPlateNumber($queries){
      $whereClause = [];
      foreach ($queries as $query) {
        $word = '%' . $query . '%';
        $whereClause[] = ['name', 'like', $word];
      }

      $totalRestNames = DB::table('users')
        ->where(
            $whereClause
          )
        ->count();

      $whereClause = [];
      foreach ($queries as $query) {
        $plate = '%' . $query . '%';
        $whereClause[] = ['plate_name', 'like', $plate];
      }
      $whereClause[] = ['visible', '=', '1'];
      $whereClause[] = ['destroyed', '=', '0'];
      $whereClause[] = ['availability', '=', '1'];

      $totalPlatesNames = DB::table('plates')
      ->where(
          $whereClause
        )
      ->count();

      return [
        'total_rest_names' => $totalRestNames,
        'total_plates_names' => $totalPlatesNames,
      ];
    }
}
