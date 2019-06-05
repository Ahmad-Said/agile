<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('set_user', function(Blueprint $table)
        {
            $table->increments('id'); // no need just for interface of phpmyadmin
            
            $table->integer('set_id')->unsigned()->nullable();
            $table->foreign('set_id')->references('id')->on('sets')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('status')->default('pending'); 
            // we can check any question answer to see if is null to know if is a pending status or done
            // but added status to make it simple always we have the choice memory vs cpu 
            // i choose to optimise both but when they are inverse proportional i choose to optimize cpu
            // so instead of adding here a string answer with imploded response on question 
            // i created a new relatin table see migrations question_user

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
        //
        Schema::dropIfExists('set_user');
    }
}
