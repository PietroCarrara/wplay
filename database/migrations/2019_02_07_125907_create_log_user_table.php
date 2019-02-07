<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->integer('log_id')->unsigned()->index();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('log_id')->references('id')->on('logs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_user');
    }
}
