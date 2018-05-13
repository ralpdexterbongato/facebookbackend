<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReactablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactables', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('type');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('reactable_id');
            $table->string('reactable_type','100');
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
        Schema::dropIfExists('reactables');
    }
}
