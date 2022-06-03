<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarReportItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_report_items', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('项目名称');
            $table->string('name')->comment('项目英文字段');
            //结果状态
            $table->json('options')->nullable()->comment('结果状态选项');
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
        Schema::dropIfExists('car_report_items');
    }
}
