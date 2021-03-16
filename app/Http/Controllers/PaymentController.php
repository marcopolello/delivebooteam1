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

    $data = $request -> all();

    $plates_selected = [];
    $to_pay = 0;
    $delivery_cost = 0;

    $data_array = [];

    $cart = json_decode($data['cart'], true);

    // dd($cart, $data);

    foreach ($cart as $value) {
        $plate_select = Plate::findOrFail($value['plate_id']);
        $delivery_cost = ($plate_select -> user -> delivery_cost) / 100;

        $discounted = $plate_select -> price * (100 - $plate_select -> discount);

        $discounted = round($discounted / 10000, 2);
        $plate_select -> price = $discounted;

        $to_pay += $discounted;

        $plates_selected[] = $plate_select;
    }

    $data_array['plates'] = $plates_selected;
    $data_array['topay'] = $to_pay;
    $data_array['delivery'] = $delivery_cost;
    $data_array['plateselect'] = $plate_select;

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
      $restoraunt_id = $plate_model_select['user_id'];
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
      'email' => 'required|email|min:5|max:50',
      'phone' => 'required|string|min:6|max:30',
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

  public function checkout(Request $request, $id) {

    $gateway = new \Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    // dd($request -> all(), $id);

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
    // dd("dati pagante: ", $payingEmail, $name, $lastName , "dati rest: ", $restEmail, $restName);

    $order = Order::findOrFail($id);
    $orderFloat = $order['total_price'] / 100;
    $amountFloat = floatval($amount);
    // dd(gettype($amount), floatval($amount), $request, $orderFloat);
    if ($orderFloat == $amountFloat) {
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
          'submitForSettlement' => true
          ]
      ]);

      if ($result->success) {
          // invio mail al pagamento
          Mail::to($payingEmail)->send(new PayMail($payingEmail));
          // dd($result);
          $order = Order::findOrFail($id);
          // dd($order["payment_state"]);
          $order["payment_state"] = 1;
          $order -> update();

          // invio mail al pagamento
          return redirect() -> route('index') -> with("success_message", "Transazione eseguita con successo. Ti abbiamo inviato un' email di conferma");
      } else {
          $errorString = "";

          foreach($result->errors->deepAll() as $error) {
              $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
          }

          // $_SESSION["errors"] = $errorString;
          // header("Location: " . $baseUrl . "index.php");
          return redirect() -> route('index') -> withErrors('An error occured with the message: ' . $result -> message);
      }
    } else {
      return redirect() -> route('fail') -> with("error_message", "Ci dispiace molto, la transazione non è andata a buon fine, riprova e sarai più fortunato ;D");
    }

  }

  public function fail() {
    return view('orders.fail-order');
  }


}
