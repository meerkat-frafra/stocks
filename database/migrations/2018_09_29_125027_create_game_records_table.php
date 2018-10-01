<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('game_records');

        Schema::create('game_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('roomId'); // ゲーム部屋No
            $table->integer('memberId'); // メンバーId
            $table->text('records'); // 手持ちのカード情報
            $table->text('remaining'); // 残りの枚数
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
        Schema::dropIfExists('game_records');
    }
}
