<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Computer>
 */
class ComputerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'computer_name' => $this->faker->bothify('Lab#-PC##'),
            'model' => $this->faker->randomElement(['Dell Optiplex 7090', 'HP EliteDesk 800', 'Lenovo ThinkCentre']),
            'operating_system' => $this->faker->randomElement(['Windows 10 Pro', 'Windows 11', 'Ubuntu 22.04']),
            'processor' => $this->faker->randomElement(['Intel Core i5-11400', 'Intel Core i7-12700', 'AMD Ryzen 5']),
            'memory' => $this->faker->randomElement([8, 16, 32]), // RAM 8, 16 hoặc 32GB
            'available' => $this->faker->boolean(80), // 80% máy hoạt động bình thường
        ];
    }
}
