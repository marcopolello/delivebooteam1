<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plate extends Model
{

  protected $fillable = [
    'plate_name',
    'ingredients',
    'description',
    'price',
    'visible',
    'availability',
    'discount',
    'category_id',
    'img',
  ];

  public static function getDiscount() {
    $num = rand(1, 3);
    if($num > 2) {
      $disc = rand(1, 50);
    } else {
      $disc = 0;
    }
    return $disc;
  }

  public static function getAvail() {
    $num = rand(1, 10);
    return $num > 2 ? 1 : 0;
  }

  public function user(){
    return $this -> belongsTo(User::class);
  }

  public function category(){
    return $this -> belongsTo(Category::class);
  }

  public function orders(){
    return $this -> belongsToMany(Order::class);
  }
}
