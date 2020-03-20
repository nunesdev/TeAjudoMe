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
          $table->increments('id');
          $table->string('name');
          $table->string('email')->unique()->nullable()->default(null);
          $table->string('password', 60)->nullable()->default(null);
          $table->string('slug');
          $table->integer('city_id')->unsigned();
          $table->string('address')->nullable()->default(null);
          $table->string('lat')->nullable()->default(null);
          $table->string('lng')->nullable()->default(null);
          $table->string('image')->nullable()->default(null);
          $table->enum('type', ['volunteer', 'user']);
          $table->enum('status', ['a', 'p'])->comment('a=active, p=pending');
          $table->rememberToken();
          $table->timestamps();

          $table->foreign('city_id')->references('id')->on('cities');
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
