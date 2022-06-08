<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargingPilesTable extends Migration
{
    /**
     * 充电桩表
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charging_piles', function (Blueprint $table) {
            $table->id();
//            设备ID:300231
            $table->string('device_id')->unique()->comment('设备ID');
            //            品牌:Star Charge
            $table->string('brand')->comment('品牌');
//            设备类型:DH-DC0050XG57
            $table->string('model')->comment('型号');
//            車位外鍵
            $table->unsignedBigInteger('stall_id')->comment('车位外键');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charging_piles');
    }
}
