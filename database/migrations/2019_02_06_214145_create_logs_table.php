<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message');
            $table->integer('project_id')->unsigned()->nullable();
            $table->integer('task_id')->unsigned()->nullable();
            $table->integer('comment_id')->unsigned()->nullable();

            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('comment_id')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
