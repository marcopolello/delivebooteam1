<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Typology;

class UserSeeder extends Seeder
{

    public function run()
    {
      factory(User::class, 50)->create()->each(function ($user) {
        $typologies = Typology::inRandomOrder()->limit(rand(1,4)) -> get();
        $user -> typologies() -> attach($typologies);
      });
    }


}
