<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\CompostagemMaterial;
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
            'descricao' => $this->faker->word(),
            'volume' => json_decode('{"quantidade": "1 pote de sorvete cheio"}',true),
            'material' => ["Legumes", "Verduras"],
            'tipo' => $this->faker->numberBetween(1, 3),
            'foto' => $this->faker->imageUrl(640, 480),
        ];
    }
}
