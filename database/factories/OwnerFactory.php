<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OwnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'houseNumber' => $this->faker->numberBetween(1, 100),
            'householder_name' => $this->faker->name,
            'householder_idNumber' => $this->faker->numberBetween(100000000, 999999999),
            'householder_mobile' => $this->faker->phoneNumber,
            'maritalStatus' => true
        ];
    }
}
