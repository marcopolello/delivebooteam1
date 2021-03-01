<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plates', function (Blueprint $table) {
            $table->id();

            $table->string('plate_name', 30);
            $table->text('ingredients', 2000);
            $table->string('description') -> nullable();
            $table->string('price', 6);
            $table->boolean('visible');
            $table->tinyInteger('discount');
            $table->boolean('availability');
            $table->string('img') -> nullable();
            $table->unsignedBigInteger('category_id') -> nullable();
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plates');
    }
}
