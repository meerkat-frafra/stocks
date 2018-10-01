<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('game_rooms');

        Schema::create('game_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('owner'); // オーナー名
            $table->string('roomname'); // 遊び場の名前
            $table->integer('target'); // カードを引く人
            $table->integer('wait'); // 待ち状態フラグ
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
        Schema::dropIfExists('game_rooms');
    }
}
