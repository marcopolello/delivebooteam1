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

      'plate_name' => 'required|string|max:30',
      'ingredients' =>  'required|string|min:2|max:2000',
      'description' =>  'nullable|string|min:2|max:255',
      'price_euro' =>   'required|integer|min:0|max:9999',
      'price_cents' => 'required|integer|min:0|max:99',
      'visible' =>      'required|integer|min:0|max:1',
      'discount' =>     'required|integer|min:0|max:100',
      'availability' => 'required|integer|min:0|max:1',
      'img' =>          'nullable|image|max:20240',
      'category_id' =>  'nullable',

    ]) -> validate();

    $plate_price = $data['price_euro'] . $data['price_cents'];

    $plate = Plate::findOrFail($id);
    
    if ($data['img']) {
      $this -> updateImgPlate($data -> file('img'), $id);
    }

    $category = Category::findOrFail($data['category_id']);

    $plate -> price = $plate_price;

    $plate -> update($data);

    if ($data['category_id']) {
      $plate -> category() -> associate($category);
    } else {
      $plate -> category() -> dissociate();
    }

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
