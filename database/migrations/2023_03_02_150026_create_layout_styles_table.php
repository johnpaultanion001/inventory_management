<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_styles', function (Blueprint $table) {
            $table->id();
            $table->string('navbar_color');
            $table->string('navbar_text_color');
            $table->string('navbar_logo');
            $table->string('banner_color');
            $table->string('banner_text_color');
            $table->string('banner_logo');
            $table->string('slider_image1');
            $table->string('slider_image2');
            $table->string('slider_image3');
            $table->string('slider_image4');
            $table->string('slider_image5');
            $table->string('footer_color');
            $table->string('footer_text_color');
            $table->string('footer_logo');

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
        Schema::dropIfExists('layout_styles');
    }
}
