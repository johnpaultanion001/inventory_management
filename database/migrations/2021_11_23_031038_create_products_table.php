<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image1')->nullable();

            $table->string('stock')->nullable();
            $table->string('unit')->nullable();
            $table->string('code')->nullable();
            $table->longText('description')->nullable();
            $table->string('area')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('price')->nullable();
            $table->string('retailed_price')->nullable();


            $table->string('category_id')->nullable();
            $table->string('discount')->default(0);
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
        Schema::dropIfExists('products');
    }
}
