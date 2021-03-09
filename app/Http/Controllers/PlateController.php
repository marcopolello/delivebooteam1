<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plate;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Validator;

class PlateController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function platesIndex(){
    $user = Auth::user();
    return view('plates.plates-index', compact('user'));
  }

  public function platesCreate() {

    $categories = Category::all();

    return view('plates.plate-create', compact('categories'));
  }

  public function plateStore(Request $request) {

    $data = $request -> all();

    if (!array_key_exists('visible', $data)) {
      $data['visible'] = 0;
    }

    if (!array_key_exists('availability', $data)) {
      $data['availability'] = 0;
    }



    // trasformo il prezzo da due valori ad un valore
    $plate_price = ($data['price_euro'] * 100) + $data['price_cents'];
    unset($data['price_euro']);
    unset($data['price_cents']);

    $data['price'] = $plate_price;

    Validator::make($data, [

      'plate_name' =>   'required|string|max:30',
      'ingredients' =>  'required|string|min:2|max:2000',
      'description' =>  'nullable|string|min:2|max:255',
      'price' =>        'required|integer|min:0|max:999999',
      'visible' =>      'nullable|integer|min:0|max:1',
      'discount' =>     'required|integer|min:0|max:100',
      'availability' => 'nullable|integer|min:0|max:1',
      'img' =>          'nullable|image|max:20240',
      'category_id' =>  'nullable',

    ]) -> validate();

    $plate = Plate::make($data);

    $plate -> price = $plate_price;

    // foto 
    if (array_key_exists('img', $data)) {

      $img = $request -> file('img');

      $ext = $img -> getClientOriginalExtension();
      $name = rand(100000, 999999) . '_' . time();
      $fileName = $name . '.' . $ext;

      $img -> storeAs('plates', $fileName, 'public');
      $plate -> img = $fileName;
    }
    // fine foto

    if ($data['category_id']) {
      $category = Category::findOrFail($data['category_id']);
      $plate -> category() -> associate($category);
    }

    $user = Auth::user() -> id;
    $plate -> user() -> associate($user);
    
    $plate -> save();

    return redirect() -> route('plates-index');
  }

  public function platesEdit($id) {
    $plate = Plate::findOrFail($id);
    $categories = Category::all();

    return view('plates.plate-edit', compact('plate', 'categories'));
  }

  public function platesUpdate(Request $request, $id) {

    $data = $request -> all();

    if (!array_key_exists('visible', $data)) {
      $data['visible'] = 0;
    }

    if (!array_key_exists('availability', $data)) {
      $data['availability'] = 0;
    }

    Validator::make($data, [

      'plate_name' =>   'required|string|max:30',
      'ingredients' =>  'required|string|min:2|max:2000',
      'description' =>  'nullable|string|min:2|max:255',
      'price_euro' =>   'required|integer|min:0|max:9999',
      'price_cents' =>  'required|integer|min:0|max:99',
      'visible' =>      'required|integer|min:0|max:1',
      'discount' =>     'required|integer|min:0|max:100',
      'availability' => 'required|integer|min:0|max:1',
      'img' =>          'nullable|image|max:20240',
      'category_id' =>  'nullable',

    ]) -> validate();

    $plate_price = ($data['price_euro'] * 100) + $data['price_cents'];

    $plate = Plate::findOrFail($id);
    $plate -> price = $plate_price;

    if (array_key_exists('img', $data)) {
      $this -> updateImgPlate($request -> file('img'), $id);
      unset($data['img']);
    }   

    $plate -> update($data);

    $category = Category::findOrFail($data['category_id']);
    $plate -> category() -> associate($category);
    
    $plate -> save();

    return redirect() -> route('plates-index');
  }

  public function deleteImg($id){

    $this->fileDeletePlateImg($id);
    $plate = Plate::findOrFail($id);
    $plate -> img = null;
    $plate -> save();

    return redirect() -> route('plates-index');
  }

  public function deletePlate($id){
    $plate = Plate::findOrFail($id);

    $this->fileDeletePlateImg($id);
    $plate -> img = null;

    $plate -> destroyed = 1;

    $plate -> save();

    return redirect() -> route('plates-index');
  }

  private function updateImgPlate($img, $id) {

    $this -> fileDeletePlateImg($id);

    $ext = $img -> getClientOriginalExtension();
    $name = rand(100000, 999999) . '_' . time();

    $fileName = $name . '.' . $ext;

    $img -> storeAs('plates', $fileName, 'public');

    $plate = Plate::findOrFail($id);
    $plate -> img = $fileName;
    $plate -> save();
  }

  private function fileDeletePlateImg($id) {

    $plate = Plate::findOrFail($id);

    try {
      $fileName = $plate -> img;
      if ($fileName) {
        $file = storage_path('app/public/plates/' . $fileName);
        File::delete($file);
      }
    } catch (\Exception $e) {}
  }
}
