<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',12)->unique();
            $table->string('password', 255);
            //$table->string('country_code')->default('+86');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->text('intro')->nullable();
            $table->text('avatar_url')->nullable();
            $table->timestamps();
        });

        // '<img src="{{$user->avatar_url}}"">'
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
