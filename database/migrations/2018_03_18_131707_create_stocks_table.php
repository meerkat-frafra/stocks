<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('stocks');
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('category')->unsigned()->index(); // カテゴリ
            $table->string('name'); // 商品名
            $table->integer('price'); // 購入価格
            $table->string('shop'); // 購入店舗
            $table->integer('space'); // 置き場
            $table->datetime('purchase_date'); // 購入日時
            $table->datetime('limit_date'); // 賞味期限
            $table->integer('balance'); // 在庫
            $table->integer('usage'); // 使用量
            $table->text('memo'); // メモ
            $table->integer('rebuy'); // リピート購入
            $table->integer('rank'); // 表示順位
            $table->boolean('is_sync'); // 自動連携かどうか
            $table->string('receipt_id'); // レシート ID
            $table->boolean('is_show'); // 表示フラグ
            $table->integer('author'); // 登録者
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
        Schema::dropIfExists('stocks');
    }
}
