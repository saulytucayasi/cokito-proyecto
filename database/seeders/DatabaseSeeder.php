<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AcademiaSeeder::class,
            CicloSeeder::class,
            TrabajadorSeeder::class,
            CursoSeeder::class,
            EstudianteSeeder::class,
            MatriculaSeeder::class,
            SesionSeeder::class,
            MaterialSeeder::class,
            VideoSeeder::class,
        ]);
    }
}
