<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Academia;

class AcademiaSeeder extends Seeder
{
    public function run(): void
    {
        Academia::create([
            'nombre' => 'COKITO+ Academia',
            'Direccion' => 'Av. Tecnología 123, Lima, Perú',
            'telefono' => '+51 999 888 777',
            'director' => 'Dr. Carlos Mendoza'
        ]);
    }
}