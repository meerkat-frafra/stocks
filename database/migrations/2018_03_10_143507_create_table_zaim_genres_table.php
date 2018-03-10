<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableZaimGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('zaim_genres');
        Schema::create('zaim_genres', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('genre_id')->unsigned();    // ジャンル ID
            $table->string('name');                     // ジャンル名
            $table->integer('sort');                    // 表示ランク
            $table->unsignedTinyInteger('active');      // 有効フラグ
            $table->integer('category_id');             // カテゴリ ID
            $table->integer('parent_genre_id');         // 親ジャンル ID
            $table->datetime('modified');               // 更新日時
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
        Schema::dropIfExists('zaim_genres');
    }
}
