<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargingResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charging_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('charging_pile_id')->nullable()->constrained()->onDelete('set null')->comment('充电桩ID');
            $table->foreignId('charging_report_id')->nullable()->constrained()->onDelete('set null')->comment('充电报表ID');
            $table->json('result')->comment('报告结果');
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
        Schema::dropIfExists('charging_results');
    }
}
