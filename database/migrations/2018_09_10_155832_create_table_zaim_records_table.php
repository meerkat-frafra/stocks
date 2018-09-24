<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableZaimRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('zaim_records');
        Schema::create('zaim_records', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedBigInteger('zaim_id');           // Zaim ID
            $table->unsignedBigInteger('zaim_user_id');      // Zaim ユーザ ID
            $table->date('date');                            // レシート発行日付
            $table->string('mode');                          // モード
            $table->integer('category_id');                  // カテゴリ ID
            $table->integer('genre_id');                     // ジャンル ID
            $table->integer('from_account_id');              // 振替元
            $table->unsignedBigInteger('to_account_id');     // 振替先
            $table->BigInteger('amount');                    // 価格
            $table->text('comment');                         // コメント
            $table->unsignedTinyInteger('active');           // 有効フラグ
            $table->datetime('created');                     // 登録日
            $table->string('currency_code');                 // 通貨種別
            $table->string('name');                          // 商品名
            $table->unsignedBigInteger('receipt_id');               // レシート ID
            $table->string('place_uid');                     // 店舗 ID
            $table->string('place');                         //  店舗名
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
        Schema::dropIfExists('zaim_records');
    }
}
