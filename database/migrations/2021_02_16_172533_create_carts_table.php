<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->dateTime('order_date')->nullable();
            $table->dateTime('arrived_date')->nullable();

            $table->unsignedBigInteger('status_id')->default('1'); //1-Activo, 2-Pendiente, 3-Aprobado, 4-Cancelado, 5-Finalizado
            $table->foreign('status_id')->references('id')->on('cart_statuses');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('carts');
    }
}
