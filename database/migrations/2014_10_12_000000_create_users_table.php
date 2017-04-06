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
            $table->string('fullName');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('role');
            $table->rememberToken();
            $table->timestamps();
            $table->integer('user_and_employment_id')->nullable();
            $table->integer('user_and_education_id')->nullable();
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
