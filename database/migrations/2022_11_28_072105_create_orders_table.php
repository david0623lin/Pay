<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id', 32)->unique();
            $table->integer('merchant_id')->index();
            $table->integer('payment_id')->index();
            $table->string('item', 20);
            $table->integer('customer_id'); // 顧客id
            $table->integer('amount')->default(0);; // 金額
            $table->integer('real_amount')->default(0); // 已收付金額
            $table->integer('status')->default(0);;
            // $table->string('action', 10); // 請求類別
            $table->string('currency', 10)->default('TWD');;
            $table->string('callback')->default('');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
