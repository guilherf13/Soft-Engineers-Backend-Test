<?php

namespace Database\Factories;

use App\Models\Debt;
use Illuminate\Database\Eloquent\Factories\Factory;

class DebtFactory extends Factory
{
    protected $model = Debt::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name, // Campo obrigatório
            'governmentId' => $this->faker->uuid, // Campo opcional
            'email' => $this->faker->unique()->safeEmail, // Campo obrigatório
            'debtAmount' => $this->faker->randomFloat(2, 100, 10000), // Campo obrigatório
            'debtDueDate' => $this->faker->dateTimeBetween('+1 week', '+1 month'), // Campo obrigatório
            'debtID' => $this->faker->uuid, // Campo opcional
            'processed' => false,
        ];
    }
}
