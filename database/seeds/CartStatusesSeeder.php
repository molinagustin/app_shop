<?php

use App\CartStatus;
use Illuminate\Database\Seeder;

class CartStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CartStatus::create([
            'status' => 'Activo'
        ]);

        CartStatus::create([
            'status' => 'Pendiente'
        ]);

        CartStatus::create([
            'status' => 'Aprobado'
        ]);

        CartStatus::create([
            'status' => 'Cancelado'
        ]);

        CartStatus::create([
            'status' => 'Finalizado'
        ]);
    }
}
