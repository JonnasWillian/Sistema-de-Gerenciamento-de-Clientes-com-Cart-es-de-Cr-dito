<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'sobrenome' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'data_nascimento' => $this->faker->date,
            'endereco' => $this->faker->streetAddress,
            'telefone' => $this->faker->phoneNumber,
        ];
    }
}
