<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit_number' => $this->faker->numberBetween(1, 100),
            'unit_name' => $this->faker->numberBetween(1, 10).'单元',
            'floor_number' => $this->faker->numberBetween(1, 33),
            'total_households' => $this->faker->numberBetween(1, 100),
        ];
    }
}
