<?php

use App\PayMethod;
use Illuminate\Database\Seeder;

class PayMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PayMethod::create([
            'name' => 'Sin Pagar'
        ]);

        PayMethod::create([
            'name' => 'Efectivo'
        ]);

        PayMethod::create([
            'name' => 'PayPal'
        ]);

        PayMethod::create([
            'name' => 'Mercado Pago'
        ]);
    }
}
