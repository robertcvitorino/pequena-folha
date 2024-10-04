<?php

namespace Database\Seeders;

use App\Models\Compostagem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompostagemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Compostagem::factory(10)->create();
    }
}
