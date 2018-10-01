<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('game_members');

        Schema::create('game_members', function (Blueprint $table) {
            $table->increments('id'); // メンバーId
            $table->integer('roomId'); // ゲーム部屋No
            $table->string('name'); // メンバー名
            $table->integer('isOwner'); // 順番
            $table->integer('sort'); // 順番
            $table->text('cards'); // 手持ちのカード情報
            $table->integer('cardCount'); // 残りの枚数
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
        Schema::dropIfExists('game_members');
    }
}
