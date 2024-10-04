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
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);

        if (config('app.env') === 'production') {
            $this->call([
                //ShieldSeeder::class,
            ]);
        } else {
            $this->call([
                PessoaSeeder::class,
                EnderecoSeeder::class,
                TelefoneSeeder::class,
                UserSeeder::class,
                MaterialSeeder::class,
                CompostagemSeeder::class,
            ]);
        }
    }
}
