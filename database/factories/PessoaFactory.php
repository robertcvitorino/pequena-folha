<?php

namespace Database\Factories;

use App\Models\Residente;
use App\Models\User;
use App\Models\Visitante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pessoa>
 */
class PessoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_completo' => fake()->name(),
            'data_nascimento' => fake()->date('Y-m-d'),
            'user_id' => fake()->numberBetween(1, User::count()),
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
