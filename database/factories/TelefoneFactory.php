<?php

namespace Database\Factories;

use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Telefone>
 */
class TelefoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero' => $this->faker->phoneNumber,
            'principal' => $this->faker->boolean,
            'user_id' => $this->faker->numberBetween(1, User::count()),
        ];
    }
}
