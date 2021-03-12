<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $defaultCategories = [
        'nessuna',
        'fritti',
        'antipasti',
        'pizza',
        'primi piatti',
        'secondi piatti',
        'contorni',
        'dolci',
        'bevande',
        'vini',
        'birre',
        'amari',
        'superalcolici',
      ];

      foreach ($defaultCategories as $category) {
        $newcategory = new Category();
        $newcategory ->category = $category;
        $newcategory -> save();
      }

    }
}
