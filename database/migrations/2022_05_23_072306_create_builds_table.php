<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildsTable extends Migration
{
    /**
     * 楼盘信息表
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('builds', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('楼盘名称');
            //项目名称
            $table->string('project_name')->comment('项目名称');
            //项目地址
            $table->string('project_address')->nullable()->comment('项目地址');
//            行政管辖区域
            $table->string('administrative_area')->nullable()->comment('行政管辖区域');
//            区政府地址
            $table->string('district_address')->nullable()->comment('区政府地址');
//            街道办名称
            $table->string('street_name')->nullable()->comment('街道办名称');
            //街道办地址
            $table->string('street_address')->nullable()->comment('街道办地址');
            //居委会名称
            $table->string('committee_name')->nullable()->comment('居委会名称');
            //居委会地址
            $table->string('committee_address')->nullable()->comment('居委会地址');
            //居委会书记
            $table->string('councilor')->nullable()->comment('居委会书记');
            //居委会联系电话
            $table->string('councilor_phone')->nullable()->comment('居委会联系电话');
            //物业公司名称
            $table->string('property_company_name')->nullable()->comment('物业公司名称');
            //物业公司地址
            $table->string('property_company_address')->nullable()->comment('物业公司地址');
            //物业公司法人
            $table->string('property_company_legal_person')->nullable()->comment('物业公司法人');
            //物业公司联系电话
            $table->string('property_company_phone')->nullable()->comment('物业公司联系电话');
            //物业公司联系人
            $table->string('property_company_contact')->nullable()->comment('物业公司联系人');
            //物业公司联系人电话
            $table->string('property_company_contact_phone')->nullable()->comment('物业公司联系人电话');
            //业主委员会名称
            $table->string('owner_committee_name')->nullable()->comment('业主委员会名称');
            //业主委员会地址
            $table->string('owner_committee_address')->nullable()->comment('业主委员会地址');
            //业主委员会主任
            $table->string('owner_committee_chairman')->nullable()->comment('业主委员会主任');
            //业主委员会联系电话
            $table->string('owner_committee_phone')->nullable()->comment('业主委员会联系电话');
            //业主委员会联系人
            $table->string('owner_committee_contact')->nullable()->comment('业主委员会联系人');
            //业主委员会联系人电话
            $table->string('owner_committee_contact_phone')->nullable()->comment('业主委员会联系人电话');
            //项目介绍人
            $table->string('project_introducer')->nullable()->comment('项目介绍人');
            //项目介绍人电话
            $table->string('project_introducer_phone')->nullable()->comment('项目介绍人电话');
            //项目介绍人身份证号
            $table->string('project_introducer_id_card')->nullable()->comment('项目介绍人身份证号');
            //房屋类型（商品房、安置房、联建房、集资房、房改房、自建房、其他）
            $table->enum('house_type',
                ['commercial', 'resettlement', 'union', 'fundraising', 'changesroom', 'selfbuilt', 'other'])->nullable()
                ->comment('房屋类型（商品房、安置房、联建房、集资房、房改房、自建房、其他）');

            //住宅数
            $table->integer('households_num')->nullable()->comment('住宅数');
            //商业数
            $table->integer('commercials_num')->nullable()->comment('商业数');
            //仓库数
            $table->integer('warehouses_num')->nullable()->comment('仓库数');
            //停车位数
            $table->integer('parking_num')->nullable()->comment('停车位数');
            //建筑面积
            $table->decimal('building_area', 10, 2)->nullable()->comment('建筑面积');
            //土地面积
            $table->decimal('land_area', 10, 2)->nullable()->comment('土地面积');
            //建筑总面积
            $table->decimal('total_area', 10, 2)->nullable()->comment('建筑总面积');
            //土地总面积
            $table->decimal('land_total_area', 10, 2)->nullable()->comment('土地总面积');
            //土地性质（集体土地、国有土地、划拨土地、出让性质、其他）
            $table->enum('land_nature', ['collective', 'state', 'transfer', 'lease', 'other'])->nullable()
                ->comment('土地性质（集体土地、国有土地、划拨土地、出让性质、其他）');

//项目主体单位名称
            $table->string('project_unit_name')->nullable()->comment('项目主体单位名称');
            //项目主体单位地址
            $table->string('project_unit_address')->nullable()->comment('项目主体单位地址');
            //项目主体单位法人
            $table->string('project_unit_legal_person')->nullable()->comment('项目主体单位法人');
            //项目主体单位联系电话
            $table->string('project_unit_phone')->nullable()->comment('项目主体单位联系电话');
            //项目主体单位是否灭失
            $table->enum('project_unit_is_lost', ['yes', 'no'])->nullable()->comment('项目主体单位是否灭失');
            //修建时间
            $table->date('build_time')->nullable()->comment('修建时间');
            //竣工时间
            $table->date('completion_time')->nullable()->comment('竣工时间');
            //灭失原因
            $table->string('lost_reason')->nullable()->nullable()->comment('灭失原因');
//项目承建商名称
            $table->string('project_builder_name')->nullable()->comment('项目承建商名称');
            //项目承建商地址
            $table->string('project_builder_address')->nullable()->comment('项目承建商地址');
            //项目承建商法人
            $table->string('project_builder_legal_person')->nullable()->comment('项目承建商法人');
            //项目承建商联系电话
            $table->string('project_builder_phone')->nullable()->comment('项目承建商联系电话');
            //项目承建商是否灭失
            $table->enum('project_builder_is_lost', ['yes', 'no'])->nullable()->comment('项目承建商是否灭失');
            //项目承建商灭失原因
            $table->string('project_builder_lost_reason')->nullable()->comment('项目承建商灭失原因');
            //项目附加信息
            $table->string('project_additional_information')->nullable()->comment('项目附加信息');
            //软删除


            //项目批复文件
            $table->json('project_approval_document')->nullable()->comment('项目批复文件');
//            土地批复文件
            $table->json('land_approval_documents')->nullable()->comment('土地批复文件');
//            规划建设许可证
            $table->json('planning_construction_permits')->nullable()->comment('规划建设许可证');
//            施工许可证
            $table->json('construction_permit')->nullable()->comment('施工许可证');

//            消防验收报告
            $table->json('fire_acceptance_report')->nullable()->comment('消防验收报告');

//            联合验收报告
            $table->json('joint_acceptance_report')->nullable()->comment('联合验收报告');

//            施工图审批文件
            $table->json('construction_drawing_examination_approval_documents')->nullable()->comment('施工图纸审批文件');

//            环保审核文件
            $table->json('environmental_audit_file')->nullable()->comment('环保审核文件');

//            项目竣工图
            $table->json('project_completion_figure')->nullable()->comment('项目竣工图');

            $table->timestamp('deleted_at')->nullable()->comment('删除时间');

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
        Schema::dropIfExists('builds');
    }
}
