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
        Schema::connection("tests")->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 24);
            $table->float('rating', 8, 1);
            $table->timestamps();
        });

        Schema::connection("tests2")->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 24);
            $table->float('rating', 8, 1);
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
        Schema::connection("tests")->dropIfExists('users');
        Schema::connection("tests2")->dropIfExists('users');
    }
}
