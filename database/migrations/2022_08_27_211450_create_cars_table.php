<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('rate');
            $table->boolean('invoice');
            $table->boolean('monthly');
            $table->timestamps();
        });
        
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->foreignId('type_id')->references('id')->on('types')->comment("Guarda el tipo de vehiculo");
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
        Schema::dropIfExists('types');
        Schema::dropIfExists('cars');
    }
}
