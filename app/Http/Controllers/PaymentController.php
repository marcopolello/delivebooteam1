<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;
use App\Order;
use App\Plate;
use App\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Mail\PayMail;





class PaymentController extends Controller
{
  public function create(Request $request) {

    $data = $request -> json() -> all();
    $plates_selected = [];
    $to_pay = 0;
    $delivery_cost = 0;

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

    return view('orders.order-create', compact('plates_selected', 'to_pay', 'delivery_cost'));
  }

  public function store(Request $request) {
    $data = $request -> all();
    // dd($data);

    // result è un array con id dei plates selected
    foreach ($data as $key => $value) {
      $exp_key = explode('_', $key);
      if($exp_key[0] == 'plate'){
         $id_plates[] = $value;
       }
    }
    // dd($id_plates);

    $tot_price = 0;
    $plates = Plate::all();
    $platesAttach = [];

    foreach ($plates as $plate) {
      foreach ($id_plates as $id_frontend) {
        // dd($id_frontend, $plate -> id);
        if ($id_frontend == $plate -> id) {
          $tot_price = $tot_price + $plate -> price;
          $platesAttach[] = $plate;
        }
      }
    }
    // dd($tot_price);

    $data['total_price'] = $tot_price;

    // array di piatti ordinati
    $platesOrd = [];

    foreach ($data as $key => $value) {
      $exp_key = explode('_', $key);
      if($exp_key[0] == 'plate'){
         $platesOrd[] = $value;
         unset($data[$key]);
       }
    }
    // dd($platesOrd, $data);

    $data['payment_state'] = 0;

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
    $newOrder -> plates() -> attach($id_plates);
    // dd($newOrder);


    return view('orders.order-show', compact('newOrder'));
  }

  // public function edit($id) {
  //   $order = Order::findOrFail($id);
  //   // dd($order);
  //   return view('orders.order-edit', compact('order'));
  // }

  public function pay() {
    $gateway = new \Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);
    $email = "email utente";

    $token = $gateway->ClientToken()->generate();

    return view('pagamento.payment', [
      'token' => $token,
      'email' => $email
    ]);
  }


  public function checkout(Request $request) {

    $gateway = new \Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);
    // dd($request);

    $emailPagamento = $_POST["email"];
    $userMail = User::all() -> first() -> email;
    // mail del ristorante
    // dd($userMail);

    $data = [];
    // passaggio della mail utente
    // dd($emailPagamento);

    // invio mail al pagamento
    Mail::to($userMail)->send(new PayMail($userMail));

    // Mail::send('mail.mail_pagamento', $data, function($message) {
    //   $message->from($userMail);
    //   $message->to($emailPagamento);
    // });


    $amount = $_POST["amount"];
    $nonce = $_POST["payment_method_nonce"];

    $result = $gateway->transaction()->sale([
        'amount' => $amount,
        'paymentMethodNonce' => $nonce,
        'customer' => [
          'firstName' => 'Tony',
          'lastName' => 'Stark',
          'email' => 'tony@avengers.com'
        ],
        'options' => [
        'submitForSettlement' => true
        ]
    ]);

    if ($result->success) {
        // header("Location: " . $baseUrl . "transaction.php?id=" . $transaction->id);
        return back() -> with('success_message', 'transazione eseguita con successo.');
    } else {
        $errorString = "";

        foreach($result->errors->deepAll() as $error) {
            $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
        }

        // $_SESSION["errors"] = $errorString;
        // header("Location: " . $baseUrl . "index.php");
        return back() -> withErrors('An error occured with the message: ' . $result -> message);
    }
  }


}
