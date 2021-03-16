<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Plate;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ottiene la lista di tutte le img presenti nella cartella examples/restaurant_icon
        $restaurant_icons = Storage::disk('public')->files('/examples/restaurant_icon');

        // Ottiene la lista di tutte le img presenti nella cartella examples/plates
        $plates_icons = Storage::disk('public')->files('/examples/plates');

        // Prendo tutti gli User uno ad uno.
        // Prendo un file casuale da examples/restaurant_icon e lo copio in restaurant_icon.
        // Salvo nel db questa informazione.

        $users = User::all();
        foreach ($users as $key => $user) {
          $rand = rand(0, (count($restaurant_icons) - 1));
          $randomFile = $restaurant_icons[$rand];

          // Ottiene l'estensione del file
          $info = pathinfo(storage_path(). $randomFile);
          $extension = $info['extension'];

          $name = rand(100000, 999999) . '_' . time();
          $fileName = $name . '.' . $extension;

          // Copia di un file cambiandogli nome
          Storage::disk('public')->copy($randomFile, 'restaurant_icon/' . $fileName);

          //Salvo nel db
          $user -> photo = $fileName;
          $user -> save();
        }

        // Ora con i piatti

        $plates = Plate::all();
        foreach ($plates as $key => $plate) {
          $rand = rand(0, (count($plates_icons) - 1));
          $randomFile = $plates_icons[$rand];

          // Ottiene l'estensione del file
          $info = pathinfo(storage_path(). $randomFile);
          $extension = $info['extension'];

          $name = rand(100000, 999999) . '_' . time();
          $fileName = $name . '.' . $extension;

          // Copia di un file cambiandogli nome
          Storage::disk('public')->copy($randomFile, 'plates/' . $fileName);

          //Salvo nel db
          $plate -> img = $fileName;
          $plate -> save();
        }


    }
}
