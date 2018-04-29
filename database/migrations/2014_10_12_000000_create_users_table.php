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
            $table->string('username',50);
            $table->string('fname',20);
            $table->string('lname',20);
            $table->string('mobile',11)->nullable();
            $table->string('email',50)->unique()->nullable();
            $table->smallInteger('gender');
            $table->smallInteger('isverified')->nullable();
            $table->smallInteger('lastSeen');
            $table->smallInteger('admin_disabled')->nullable();
            $table->smallInteger('user_disabled')->nullable();
            $table->string('password',100);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
