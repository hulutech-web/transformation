<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BuildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name.'楼盘',
            'project_name' => $this->faker->name.'项目',
            'project_address' => $this->faker->address,
            'administrative_area' => $this->faker->name,
            'district_address' => $this->faker->address,
            'street_name' => $this->faker->name,
            'councilor_phone' => $this->faker->phoneNumber,
            'project_introducer' => $this->faker->name,
            'project_introducer_phone' => $this->faker->phoneNumber,
        ];
    }
}
