<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'principal_name' => $this->faker->name,
            'principal_phone' => $this->faker->phoneNumber,
            'principal_idNo' => $this->faker->numerify('##################'),
            'home_address' => $this->faker->address,
            'agency_fee' => 20000,
            'one_time_charges' => 5000,
            'rest' => 15000,
            'nature_the_land' => $this->faker->randomElement(['集体土地', '国有土地', '划拨', '出让']),
            'replace_land' => $this->faker->randomElement(['集体土地', '国有土地', '划拨', '出让']),
            'difference_cost' => 15000,
            'supplementary_provision' => $this->faker->text(30),
            'owner_id' => $this->faker->randomElement(
            // 从数据库中查询出所有的用户
                \App\Models\Owner::pluck('id')->toArray()
            )
        ];
    }
}
