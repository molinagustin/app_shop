<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFields2ToCarts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->boolean('payed')->default(0);
            $table->datetime('pay_date')->nullable();
            /*Clave Foranea de Carts hacia PayMethods  FK */
            $table->unsignedBigInteger('pay_method_id')->default(1);
            $table->foreign('pay_method_id')->references('id')->on('pay_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn([
                'payed', 'pay_date', 'pay_method_id',
            ]);
        });
    }
}
