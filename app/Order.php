<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'phone',
    'comment',
    'address',
    'payment_state',
    'total_price',
  ];

  public function plates(){
    return $this -> belongsToMany(Plate::class);
  }
}
