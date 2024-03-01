<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string("purchase_order_id")->nullable();
            $table->string("product_id");
            $table->string("product_code");
            $table->string("unit");
            $table->float('qty');
            $table->float('unit_price');
            $table->float('total');
            $table->date('expiration')->nullable();
            $table->string('supplier')->nullable();
            $table->string("isConfirm")->default(0);
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
        Schema::dropIfExists('deliveries');
    }
}
