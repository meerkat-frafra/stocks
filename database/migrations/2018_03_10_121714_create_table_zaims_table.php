<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableZaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      //
      Schema::dropIfExists('zaims');
      Schema::create('zaims', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('user_id')->unsigned(); // ユーザ ID
          $table->string('consumer_key');         // コンシューマ ID
          $table->string('consumer_secret');      // コンシューマシークレット
          $table->string('oauth_token');          // 認証トークン
          $table->string('oauth_token_secret');   // 認証トークンシークレット
          $table->string('profile_image_url');    // プロフィール画像
          $table->string('name');                 // プロフィール名
          $table->string('zaim_user_id');         // Zaim ユーザ ID
          $table->text('user_info');              // Zaim ユーザ情報
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
        Schema::dropIfExists('zaims');
    }
}
