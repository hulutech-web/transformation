<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * 合同表
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->index()->unique()->comment('合同编号');
            $table->string('principal_name')->comment('委托人姓名');
            $table->string('principal_phone')->comment('委托人电话');
            $table->string('principal_idNo')->comment('委托人身份证号');
            $table->string('principal_add_name')->nullable()->comment('委托人2姓名');
            $table->string('principal_add_phone')->nullable()->comment('委托人2电话');
            $table->string('principal_add_idNo')->nullable()->comment('委托人2身份证号');
            $table->string('home_address')->comment('房屋地址');
            $table->decimal('agency_fee', 22, 2)->comment('代理费');
            $table->decimal('one_time_charges', 22, 2)->comment('一次性费用');
            $table->decimal('rest', 22, 2)->comment('剩余费用');
            $table->decimal('difference_cost', 22, 2)->comment('下差费用');
            $table->enum('nature_the_land', ['集体土地', '国有土地', '划拨', '出让'])->default('集体土地')->comment('原土地性质');
            $table->enum('replace_land', ['集体土地', '国有土地', '划拨', '出让'])->default('集体土地')->comment('现土地性质');
            $table->text('supplementary_provision')->nullable()->comment('补充条款');
            $table->foreignId('owner_id')->constrained()->onDelete('cascade')->comment('所属业主');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
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
        Schema::dropIfExists('contracts');
    }
}
