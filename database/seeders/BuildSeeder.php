<?php

namespace Database\Seeders;

use App\Models\Build;
use App\Models\Contract;
use App\Models\Owner;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class BuildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //楼盘-》单元-》住户
        Build::factory()->count(10)->create()->each(function ($build) {
            $build->units()->saveMany(
                Unit::factory()->count(10)->create()->each(function ($unit) use ($build) {
                    Owner::factory()->count(10)->create(['build_id' => $build->id, 'unit_id' => $unit->id])->each(function ($owner) {
                        Contract::factory()->count(2)->create(['owner_id' => $owner->id]);
                    });
                })
            );
        });
    }
}
