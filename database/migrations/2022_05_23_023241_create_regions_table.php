<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('citycode')->nullable()->comment('城市代码|区号');
            $table->string('adcode')->nullable()->comment('区域代码');
            $table->string('name')->nullable()->comment('区域名称');
            $table->text('center')->nullable()->comment('中心点');
            $table->string('level')->nullable()->comment('级别');
            $table->json('districts')->nullable()->comment('区域下的行政区划');
            //父级id
            $table->unsignedBigInteger('parent_id')->nullable()->comment('父级id');
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
        Schema::dropIfExists('regions');
    }
}