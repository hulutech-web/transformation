<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargingReportFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charging_report_fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_id')->comment('字段ID');
            $table->string('field_name')->comment('字段名称');
            $table->json('field_options')->comment('字段结果[P/F/N]');
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
        Schema::dropIfExists('charging_report_fields');
    }
}
