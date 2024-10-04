<?php

namespace Database\Seeders;

use App\Models\Pessoa;
use App\Models\Telefone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TelefoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Telefone::factory(10)->create();
    }
}
