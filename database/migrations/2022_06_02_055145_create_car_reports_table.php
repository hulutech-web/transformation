<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_reports', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->comment('公司名称');
            $table->date('report_date')->comment('报告日期');
            $table->string('car_number')->comment('车牌号');
            $table->string('car_type')->comment('车型');
            $table->string('car_brand')->comment('车辆品牌');
            //行车公里数
            $table->string('mileage')->comment('行车公里数');
            //维修项目
            $table->text('repair_project')->comment('维修项目');
            //            费用合计
            $table->string('total_cost')->comment('费用合计');
            //            内容简报
            $table->text('content_brief')->comment('内容简报');
            //备注
            $table->string('remark')->nullable()->comment('备注');
            //附件
            $table->text('attachment')->nullable()->comment('附件');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('SET NULL')->comment('报告人');
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
        Schema::dropIfExists('car_reports');
    }
}
