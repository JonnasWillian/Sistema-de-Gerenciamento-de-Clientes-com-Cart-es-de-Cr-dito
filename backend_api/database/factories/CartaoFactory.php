<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cartao>
 */
class CartaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::factory(),
            'numero' => $this->faker->creditCardNumber,
            'data_validade' => $this->faker->creditCardExpirationDate->format('Y-m-d'),
            'cvv' => $this->faker->numberBetween(1000, 9999),
        ];
    }
}
