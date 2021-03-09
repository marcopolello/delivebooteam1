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
        'primi piatti',
        'secondi piatti',
        'contorni',
        'dolci',
        'dessert',
        'bevande',
        'bibite',
        'alcolici',
      ];

      foreach ($defaultCategories as $category) {
        $newcategory = new Category();
        $newcategory ->category = $category;
        $newcategory -> save();
      }

    }
}
