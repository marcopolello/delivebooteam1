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
      factory(Order::class, 500) -> create()
      -> each(function($order){

          // per ogni ordine prende un user casuale.
          $user = User::inRandomOrder()->first();
          // assegna piatti solo di quello user
          $plates = $user->plates()->inRandomOrder()->limit(rand(1,6)) -> get();

          $order -> plates() -> attach($plates);
      });

    }
}
