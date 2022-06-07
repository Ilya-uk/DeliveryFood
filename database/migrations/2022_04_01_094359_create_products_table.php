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
            $table->id('article');
            $table->integer('category_article');
            $table->string('name', 45);
            $table->integer('price');
            $table->integer('old_price')->nullable();
            $table->string('img')->nullable();
            $table->string('weight', 6)->nullable();
            $table->string('composition')->nullable();
            $table->tinyInteger('new')->default(0);
            $table->tinyInteger('hit')->default(0);
            $table->tinyInteger('discount')->default(0);
            $table->timestamps();
            $table->softDeletes();
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
