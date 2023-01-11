<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employes>
 */
class EmployesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'gender' => $this->faker->randomElement(['Male','Famale']),
            'phone' => $this->faker->phoneNumber(),
            'photo' => $this->faker->imageUrl(100, 100),
            'team_id' => $this->faker->numberBetween(1, 10),
            'role_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
