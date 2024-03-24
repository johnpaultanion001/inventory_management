<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->string("product_code");
            $table->string("stock");
            $table->string("stock_expi");
            $table->string("phy_add")->default(0);
            $table->string("phy_minus")->default(0);
            $table->string("bad_order")->default(0);
            $table->string("sold")->default(0);
            $table->string("receive")->default(0);
            $table->string("beg_inv")->default(0);
            $table->date('expiration')->nullable();
            $table->boolean('isOrder')->default(false);
            $table->string("remarks")->nullable();
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
        Schema::dropIfExists('stock_histories');
    }
}
