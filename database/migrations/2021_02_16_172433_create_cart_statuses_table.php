<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('status'); //1-Activo, 2-Pendiente, 3-Aprobado, 4-Cancelado, 5-Finalizado

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
        Schema::dropIfExists('cart_statuses');
    }
}
