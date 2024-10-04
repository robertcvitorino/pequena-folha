<?php

namespace Database\Factories;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Endereco>
 */
class EnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cep' => $this->faker->postcode(),
            'rua' => $this->faker->streetAddress(),
            'numero' => $this->faker->buildingNumber(),
            'complemento' => $this->faker->secondaryAddress(),
            'bairro' => $this->faker->city(),
            'cidade' => $this->faker->city(),
            'estado' => $this->faker->stateAbbr(),
            'principal' => $this->faker->boolean,
            'pessoa_id' => $this->faker->numberBetween(1, Pessoa::count()),
        ];
    }
}
