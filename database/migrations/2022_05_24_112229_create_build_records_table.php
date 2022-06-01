<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('build_records', function (Blueprint $table) {
            $table->id();
            //楼盘修改内容
            $table->string('content')->comment('楼盘修改内容');
//            外键关联楼盘表
            $table->foreignId('build_id')->nullable()->constrained()->onDelete('SET NULL')->comment('外键关联楼盘表');
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
        Schema::dropIfExists('build_records');
    }
}
