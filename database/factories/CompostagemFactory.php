<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Material;
use App\Models\Pessoa;
use App\Models\User;
use Database\Seeders\MaterialSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compostagem>
 */
class CompostagemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'data' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'material_id' => $this->faker->numberBetween(1, Material::count()),
            'descricao' => $this->faker->text(50),
            'volume' => $this->faker->numberBetween(1, 100),
            'tipo' => $this->faker->numberBetween(0, 2),

        ];
    }
}
