<?php

use Illuminate\Database\Seeder;
use App\Plate;
use App\Category;
use App\User;

class PlateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Plate::class, 1500)
        -> make()
        -> each(function($plate) {
          $user = User::inRandomOrder()->first();
          $plate -> user() -> associate($user);

          $category = Category::inRandomOrder()->first();
          $plate -> category() -> associate($category);

          $plate -> save();
        });
    }
}
