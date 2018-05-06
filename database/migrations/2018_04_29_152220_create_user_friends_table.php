<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_friends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_idf');
            $table->unsignedInteger('user_ids');
            $table->smallInteger('isFriends')->nullable();
            $table->foreign('user_idf')->references('id')->on('users');
            $table->foreign('user_ids')->references('id')->on('users');
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
        Schema::dropIfExists('user_friends');
    }
}
