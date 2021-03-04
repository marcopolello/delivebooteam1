<?php

namespace App\Http\Controllers;
use App\Plate;
use App\User;
use App\Feedback;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
      // $plate_data = Plate::all();
      // mettere where visible : 1
      // dd($plate_data);
      // return view('welcome', compact('plate_data'));
      return view('welcome-home');
    }

    public function allRestaurant(){
      return view('vista-ristoranti-home');
    }

    public function getAllRestaurant(){
      //verranno passati dei parametri (post) che poi prenderò dalla request.
      //adesso lavoro senza, simulandoli in una variabile che poi diventerà un array di domande.
      // request = string esempio: cinese italiano
      // domande = ['cinese', 'italiano']

      // 1 cerca nelle categorie rist
      // 2 cerca nel nome ristorante
      // 3 cerca nei piatti

      $queries = ['italiano', 'cinese'];
      // 1- ricerca per categorie

      $restaurant = [];
      foreach ($queries as $typology) {

        $restaurants[] = DB::table('typology_user')
              ->join('typologies', 'typology_user.typology_id', '=', 'typologies.id')
              ->join('users', 'typology_user.user_id', '=', 'users.id')
              ->select('users.id','users.name', 'users.address', 'users.phone', 'users.description', 'users.photo', 'users.delivery_cost')
              ->where('typologies.typology', $typology)
              ->get();
      }
      // Risultato: Un array di elementi User per categoria.


      dd($restaurants);


      $restaurants = User::all('id','name', 'address', 'phone', 'description', 'photo', 'delivery_cost');

      foreach ($restaurants as $key => $restaurant) {

        // Fa ritornare il voto medio
        $votes = [];
        foreach ($restaurant->feedback as $feedback) {
          $votes[] = $feedback-> rate;
        };

        if ($votes) {
          $average = array_sum($votes)/count($votes);
          $restaurants[$key]['average_rate'] = $average;
        } else {
          $restaurants[$key]['average_rate'] = 'no-info';
        }

        // Fa ritornare le tipologie
        $typologies = [];
        foreach ($restaurant->typologies as $typology) {
          $typologies[] = $typology -> typology;
        }

        $restaurants[$key]['typologies'] = $typologies;

      };

      dd($restaurants);

      return response() -> json([
        'restaurants' => $restaurants
      ]);
    }

    public function restaurantShow($id){
      $restaurant = User::findOrFail($id);
      return view('restaurant-show',compact('restaurant'));
    }
}
