<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id'); $table->string('name')->unique(); $table->text('description'); 
            $table->string('address'); $table->integer('user_id')->unsigned()->index(); $table->integer('surface')->unsigned()->index();
            $table->enum('logement', ['appartement', 'maison'])->default('appartement'); $table->integer('rooms_number')->unsigned();
            $table->enum('location', ['vide', 'meuble'])->default('vide'); $table->integer('price')->default(0)->index();
            
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('properties');
    }
}
