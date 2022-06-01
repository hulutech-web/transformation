<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * 楼盘单元信息表
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            //单元编号
            $table->integer('unit_number')->comment('单元编号，栋编号，幢编号');
            //单元名称
            $table->string('unit_name')->comment('单元名称');
            //楼层数
            $table->integer('floor_number')->comment('楼层数');
            //总户数
            $table->integer('total_households')->comment('总户数');

            //所属楼盘
            $table->foreignId('build_id')->nullable()->constrained()->onDelete('cascade');

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
        Schema::dropIfExists('units');
    }
}
