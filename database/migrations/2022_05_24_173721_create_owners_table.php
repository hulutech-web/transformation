<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    /**
     * 业主表
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            //关联楼盘
            $table->foreignId('build_id')->nullable()->constrained()->onDelete('SET NULL');
            //关联单元
            $table->foreignId('unit_id')->nullable()->constrained()->onDelete('cascade');
            //创建人
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
//门牌号
            $table->string('houseNumber')->comment('门牌号');
            $table->string('householder_name')->comment('户主名称');
            $table->enum('householder_sex', ['male', 'female'])->default('male')->comment('性别');
            $table->string('householder_idNumber')->index()->comment('户主身份证号');
            $table->string('householder_mobile')->comment('户主电话');
            $table->enum('maritalStatus',['未婚','已婚','离异','丧偶'])->default('未婚')->comment('婚姻状况');//未婚0、已婚1、离异2、丧偶3
            /**
             * 附件信息
             */
            $table->json('id_card_copy')->nullable()->comment('身份证复印件');
            $table->json('mutual_person_id_photocopy')->nullable()->comment('共有人身份证复印件');
            $table->json('examination_prove')->nullable()->comment('婚育证明【单身证明复印件、结婚证复印件、离婚证复印件、离婚协议复印件、死亡证明复印件、火化证复印件】');
            $table->json('source_property_right_card_to_prove')->nullable()->comment('产权证来源证明,[集资建房协议、商品房买卖合同、联建房协议、安置房协议、自建房]');
            $table->json('new_apartment')->nullable()->comment('新门牌号');
            $table->json('report_surveying_mapp')->nullable()->comment('测绘报告');
            $table->json('only_room_query_report')->nullable()->comment('唯一房查询报告');
            $table->json('residence_booklet')->nullable()->comment('户口簿，以家庭为单位，未满18周岁的，全部需要提供');
            $table->json('purchase_tax_invoice')->nullable()->comment('购房交税发票');
            $table->json('deed_tax_ticket')->nullable()->comment('契税票');
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
        Schema::dropIfExists('owners');
    }
}
