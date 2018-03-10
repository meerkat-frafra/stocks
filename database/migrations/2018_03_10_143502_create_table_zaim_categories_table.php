<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableZaimCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('zaim_categories');
        Schema::create('zaim_categories', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('category_id')->unsigned(); // カテゴリ ID
            $table->string('name');                     // カテゴリ名
            $table->string('mode');                     // 種別
            $table->integer('sort');                    // 表示ランク
            $table->integer('parent_category_id');      // 親カテゴリ ID
            $table->unsignedTinyInteger('active');      // 有効フラグ
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
        Schema::dropIfExists('zaim_categories');
    }
}
