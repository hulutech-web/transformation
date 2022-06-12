<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargingReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charging_reports', function (Blueprint $table) {
            $table->id();
            $table->date('report_date')->comment('报表日期');
            $table->json('stall_ids')->comment('车位ID');
            $table->text('remark')->nullable()->comment('备注');
            $table->unsignedBigInteger('user_id')->nullable()->comment('报表人ID');
            $table->foreignId('park_id')->nullable()->constrained()->onDelete('set null')->comment('停车场ID');
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
        Schema::dropIfExists('charging_reports');
    }
}
