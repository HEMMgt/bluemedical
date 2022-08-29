<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->references('id')->on('cars')->comment("Guarda el vehiculo asociado");
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->foreignId('user_check_in')->references('id')->on('users')->comment("Guarda quién realizo el ingreso");
            $table->foreignId('user_check_out')->nullable()->references('id')->on('users')->comment("Guarda quién realizo la salida");
            $table->integer('minutes')->nullable();
            $table->boolean('completado')->default(0);
            $table->foreignId('user_id')->references('id')->on('users')->comment("Guarda quién grabo el registro");
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
        Schema::dropIfExists('records');
    }
}
