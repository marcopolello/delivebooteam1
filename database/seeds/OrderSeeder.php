<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Plate;
use App\User;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Order::class, 800) -> create()
      -> each(function($order){

          $user = User::inRandomOrder()->first();
          $plates = $user->plates()->inRandomOrder()->limit(rand(1,10)) -> get();

          $order -> plates() -> attach($plates);
      });

    }
}
