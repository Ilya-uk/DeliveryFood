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
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('courier_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('name',45)->nullable();
            $table->string('phone' ,18)->nullable();
            $table->string('email',45)->nullable();
            $table->string('street',45)->nullable();
            $table->string('house',45)->nullable();
            $table->string('apartment',45)->nullable();
            $table->integer('summa')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
