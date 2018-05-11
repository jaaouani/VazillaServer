<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id'); $table->string('fullname')->unique(); $table->string('email')->unique(); 
            $table->string('password'); $table->boolean('professional')->default(0); $table->string('token')->unique();
            $table->string('addressOne')->default(''); $table->string('addressTwo')->default('');
            $table->string('phone')->default(''); $table->string('points')->default('20'); $table->string('reference')->unique();
            $table->string('city')->default(''); $table->string('zipcode')->default('');
            $table->rememberToken(); $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
