<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePepayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pepay', function (Blueprint $table) {
            $table->string('id', 12)->primary();
            $table->string('prod_id', 30)->index();
            $table->string('name', 30);
            $table->string('currency', 10);
            $table->string('sub_pay_type', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pepay');
    }
}
