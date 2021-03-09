<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Order;
use App\Plate;
use App\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\PayMail;


class PaymentController extends Controller
{
  public function getCart(Request $request) {

    $data = $request -> json() -> all();

    $plates_selected = [];
    $to_pay = 0;
    $delivery_cost = 0;

    $data_array = [];

    foreach ($data as $value) {
      foreach ($value as $item) {

        $plate_select = Plate::findOrFail($item['plate_id']);
        $delivery_cost = ($plate_select -> user -> delivery_cost) / 100;

        $discounted = $plate_select -> price * (100 - $plate_select -> discount);

        $discounted = round($discounted / 10000, 2);
        $plate_select -> price = $discounted;

        $to_pay += $discounted;

        $plates_selected[] = $plate_select;
      }
    }

    $data_array['plates'] = $plates_selected;
    $data_array['topay'] = $to_pay;
    $data_array['delivery'] = $delivery_cost;

    session() -> flash('data', $data_array);

    return redirect() -> route('order-create');
  }

  public function create(Request $request) {

    session() -> keep(['data']);

    $data_array = session() -> get('data');

    $request->session()->reflash();

    return view('orders.order-checkout', compact('data_array'));
  }


  public function storeOrder(Request $request) {

    $data = $request -> all();
    $topay = 0;

    foreach ($data as $key => $value) {
      $exp_key = explode('_', $key);
      if($exp_key[0] == 'plate'){
        $id_plates[]=json_decode($value, true);
       }
    }

    $data['payment_state'] = 0;

    foreach($id_plates as $subplate) {
        $plates_id_final[] = $subplate['id'];
    }

    foreach ($plates_id_final as $plate_id) {

      $plate_model_select = Plate::findOrFail($plate_id);
      // ristorante a cui ordinano i piatti
      $restoraunt_id = $plate_model_select['user_id'];
      // dd($restoraunt, $plate_model_select);
      $delivery_cost = ($plate_model_select -> user -> delivery_cost);

      $discounted = $plate_model_select -> price * (100 - $plate_model_select -> discount);

      $discounted = round($discounted / 10000, 2);
      $plate_model_select -> price = $discounted;

      $topay += $discounted;

      $plates_models_selected[] = $plate_model_select['id'];
    }

    $data['total_price'] = (int)($topay * 100) + $delivery_cost;

    Validator::make($data, [

      'first_name' =>  'required|string|min:2|max:50',
      'last_name' =>  'required|string|min:2|max:50',
      'email' => 'required|string|min:3|max:50',
      'phone' => 'required|string|min:3|max:30',
      'comment' => 'nullable|string|min:0|max:255',
      'address' => 'required|string|min:5|max:255',
      'total_price' =>  'required|integer|min:0|max:999999',

    ]) -> validate();

    $newOrder = Order::make($data);
    $newOrder -> save();
    $newOrder -> plates() -> attach($plates_models_selected);
    $restoraunt = User::findOrFail($restoraunt_id);

    $gateway = new \Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    $token = $gateway->ClientToken()->generate();


    return view('orders.order-show', [
      'token' => $token,
    ], compact('newOrder', 'restoraunt', 'token'));
  }

  public function checkout(Request $request) {
    // dd($request);

    $gateway = new \Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);
    $payState = $_POST["payment_state"];
    $order_id = $_POST["order_id"];



    // dd($payState, $request);

    // dati pagante
    $payingEmail = $_POST["email"];
    $name = $_POST["name"];
    $lastName = $_POST["last_name"];

    // mail e nome del pagato(restourant)
    $restEmail = $_POST["restourant-email"];
    $restName = $_POST["restourant-name"];
    // mail del ristorante
    // dd($userMail);

    // $amount = floatval($_POST["amount"]);
    $amount = $_POST["amount"];
    $nonce = $_POST["payment_method_nonce"];
    // dd($amount, $request);
    // dd("dati pagante: ", $payingEmail, $name, $lastName , "dati rest: ", $restEmail, $restName);

    // $user = Auth::user();


    $result = $gateway->transaction()->sale([
        'amount' => $amount,
        'paymentMethodNonce' => $nonce,
        'customer' => [
          'firstName' => $name,
          'lastName' => $lastName,
          // 'firstName' => 'topo',
          // 'lastName' => 'gigio',
        ],
        'options' => [
          // mettere true se si vuole mandare in autorizzato
        'submitForSettlement' => false
        ]
    ]);

    if ($result->success) {
        // invio mail al pagamento
        Mail::to($payingEmail)->send(new PayMail($restEmail));
        // dd($result);
        $order = Order::findOrFail($order_id);
        // dd($order["payment_state"]);
        $order["payment_state"] = 1;
        $order -> update();

        // invio mail al pagamento
        return redirect() -> route('index') -> with("success_message", "transazione eseguita con successo. Ti abbiamo inviato un' email di conferma");
    } else {
        $errorString = "";

        foreach($result->errors->deepAll() as $error) {
            $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
        }

        // $_SESSION["errors"] = $errorString;
        // header("Location: " . $baseUrl . "index.php");
        return redirect() -> route('index') -> withErrors('An error occured with the message: ' . $result -> message);
    }
  }


}
