<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carinfos', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->comment('公司名称');
            $table->string('car_number')->comment('车牌号');
            $table->string('car_type')->comment('车型');
            $table->string('car_brand')->comment('车辆品牌');
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
        Schema::dropIfExists('carinfos');
    }
}
