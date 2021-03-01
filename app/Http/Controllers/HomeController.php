<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      return view('home');
    }

    //Restaurant Edit
    public function restaurantEdit(){
      $user = Auth::user();
      return view('restaurant-edit.form-view', compact('user'));
    }

    public function uploadInfo(Request $request){

      $request -> validate([
        'photo' => ['image','max:20240'],
        'description' => ['nullable','string', 'max:255'],
        'phone' => ['required', 'string', 'min:6', 'max:30'],
        'delivery_cost_euro' => ['required', 'integer', 'min:0', 'max:9999'],
        'delivery_cost_cent' => ['required', 'integer', 'min:0', 'max:99'],
      ]);

      $deliveryCost = $request['delivery_cost_euro'] . $request['delivery_cost_cent'];

      if ($request -> photo) {
        $this->updateUserIcon($request -> file('photo'));
      }

      $user = Auth::user();
      $user -> description = $request->description;
      $user -> phone = $request->phone;
      $user -> delivery_cost = $deliveryCost;
      $user -> save();

      return redirect() -> route('restaurant-edit');
    }

    public function deleteIcon(){

      $this-> fileDeleteUserIcon();

      $user = Auth::user();
      $user -> photo = null;
      $user -> save();

      return redirect() -> route('restaurant-edit');
    }

    private function updateUserIcon($img){

      $this-> fileDeleteUserIcon();

      $ext = $img -> getClientOriginalExtension();
      $name = rand(100000, 999999) . '_' . time();

      $fileName = $name . '.' . $ext;

      // Copia file in restaurant_icon
      $img -> storeAs('restaurant_icon', $fileName, 'public');

      // Salvo il nome del file nel db;

      $user = Auth::user();
      $user -> photo = $fileName;
      $user -> save();
    }

    private function fileDeleteUserIcon(){
      $user = Auth::user();

      try {
        $fileName = $user -> photo;
        if ($fileName) {
          $file = storage_path('app/public/restaurant_icon/' . $fileName);
          File::delete($file);
        }
      } catch (\Exception $e) {}
    }

    //End Restaurant Edit
}
