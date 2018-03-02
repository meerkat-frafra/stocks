<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('carts');
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('category')->unsigned()->index(); // カテゴリ
            $table->string('name'); // 商品名
            $table->integer('price'); // 前回の購入価格
            $table->string('shop'); // 前回の購入店舗
            $table->datetime('purchase_date'); // 前回購入日時
            $table->integer('rank'); // 表示順位
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
        Schema::dropIfExists('carts');
    }
}
