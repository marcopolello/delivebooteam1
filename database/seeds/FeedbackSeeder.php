<?php

use Illuminate\Database\Seeder;
use App\Feedback;
use App\User;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Feedback::class, 1500) -> make()
        -> each(function($feedback) {
            $user = User::inRandomOrder() -> first();
            $feedback -> user() -> associate($user);
            $feedback -> save();
        });
    }
}
