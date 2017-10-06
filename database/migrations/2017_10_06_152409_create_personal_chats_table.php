<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_chats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id_1')->unsigned();
            $table->integer('user_id_2')->unsigned();
            $table->timestamps();
        });

        Schema::table('personal_chats', function (Blueprint $table) {
            $table->foreign('user_id_1')->references('id')->on('users');
            $table->foreign('user_id_2')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_chats');
    }
}
