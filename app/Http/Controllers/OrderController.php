<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Order;
use App\Plate;

// temporaneo
use App\User;

class OrderController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function restaurantOrder(){
    $user = Auth::user();

    $plateOrders = [];
    $userOrdersId = [];
    foreach ($user -> plates as $plate) {

      $orders = [];
      foreach ($plate -> orders as $order) {
        $orders[] = $order;
        $userOrdersId[] = $order -> id;
      }
      $plateOrdersId[] = $orders;
    }
    // dd($user -> id ,$plateOrders, $userOrders);

    // $userOrders contiene gli id di tutti gli ordini relativi a quel ristorante.
    // Gli id possono essere anche duplicati quindi vanno scremati.

    $userOrdersId = array_unique($userOrdersId);
    $userOrders = Order::findOrFail($userOrdersId);

    return view('dashboard.orders', compact('user', 'userOrders'));
  }

  public function restaurantComanda($id){
    $order = Order::findOrFail($id);
    return view('dashboard.comanda', compact('order'));
  }

}
