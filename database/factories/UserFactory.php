<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(User::class, function (Faker $faker) {

    $restaurants = [
      "Mister Pizza",
      "Food Delivery Ex Mercato - Hamburger & tex mex",
      "Sushi oita &poke bowls",
      "Fastdrink24",
      "Coll Bubble Tea & Coffee",
      "Gado sushi",
      "Al Garghet",
      "Gelateria blue ice",
      "Pizzeria polleriapopi popi",
      "La brace",
      "Chan sushi bar",
      "Kyoto ristorante giapponese e cinese",
      "Kistorante cinese tesoro",
      "Shabu",
      "Fast drink24",
      "Sushi oita & poke bowls",
      "Ristorante xun",
      "Miss pizza forno a legna – San Giovanni",
      "Paninoteca beneduce",
      "Pizzeria friggitoria mascalzone",
      "Panineria burgeria kentia",
      "Ptrapizza",
      "Pronto Pizza",
      "Aladino's Food & Pizza",
      "Qbiq Pokeria & Bubble Tea",
      "Gusto Pizza",
      "Pizzeria Sciuè Sciuè",
      "Aldo's Pizza",
      "Cama'ffare",
      "Pizzeria Ristorante da Chi Ragas",
      "Pizzeria la piccola Capri",
      "Pizzeria cotta a legna",
      "Dolce Morso",
      "Old Wild West",
      "Burger King",
      "Alice Pizza",
      "America Graffiti",
      "Zushi",
      "The King",
      "Hat – Hamburgeria Agricola Toscana",
      "Lime – Sapori del Mondo",
      "Crops Dalads Soup & Co.",
      "Hamerica's",
      "Peschef",
      "Bowl!",
      "Maoji Street Food",
      "Mu Bao",
      "Toast Amore",
      "Capatoast Firenze",
      "Flower Burger",
      "That's Vapore",
      "Frulez - Felicidi Gusto",
      "Cookitaly",
      "Pasta Mi",
      "Bigoleria The Brothers",
      "Taco Bang - Taqueria Mexicana",
      "Santo Taco",
      "Maybu Margaritay Burritos",
      "Cioccolatitaliani",
      "Grom",
      "Noodle Bar",
      "Sentaku Ramen Bar",
      "Girarrosti Santa Rita",
      "Chickenbot",
      "Obicà ",
      "McDonald's",
      "Lievità",
      "Pokèria by NIMA",
      "Daruma Sushi - Ponte Milvio e Centro",
      "Temakinho",
      "Berberè Pizzeria",
      "Rosticceria Giacomo",
      "Burger King ",
      "Macha",
      "Grom",
      "Pasta B Jinghua",
      "Los Chicos",
      "Mamastreat",
      "Za'atar",
      "Meze Bistrot",
      "El Jadida",
      "Tanur",
      "DadoBurger",
      "Roll Eat",
      "Tamarindo Juicery",
      "Fatamorgana Nemorense",
      "Orto Gelato",
      "RIVARENO",
      "Oasi del gelato",
      "Yogorino",
      "Pasticceria Viscontea",
      "Sweet Lab",
      "PAUSA N°5",
      "Viel",
      "Girasol",
      "BERBERE' PIZZERIA - Firenze",
      "Panino & Co",
      "La Casa de Los Burritos",
      "Insalatona",
      "Una Merenda da Campioni",
      "AltaRè - Puglia Breadstorming",
    ];


    return [
        'name' => $restaurants[rand(0, count($restaurants) - 1)],
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),

        'address' => $faker ->unique()->streetAddress,
        'piva' => substr($faker ->unique() ->iban('IT'), 0, 11),
        'phone' => $faker->e164PhoneNumber,
        'description' => $faker->sentence($nbWords = rand(0, 20), $variableNbWords = true),
        'delivery_cost' => rand(100,2000),
    ];
});
