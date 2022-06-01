<template>
  <div>
    <template>
      <div>
        <a-descriptions
            :column="{ xxl: 4, xl: 3, lg: 3, md: 3, sm: 2, xs: 1 }"
            bordered
            title="楼盘详情"
        >
          <a-descriptions-item label="楼盘名称">
            {{ build.name }}
          </a-descriptions-item>
          <a-descriptions-item label="项目名称">
            {{ build.project_name }}
          </a-descriptions-item>
          <a-descriptions-item label="项目地址">
            {{ build.project_address }}
          </a-descriptions-item>
          <a-descriptions-item label="行政管辖区域">
            {{ build.administrative_area }}
          </a-descriptions-item>
          <a-descriptions-item label="区政府地址">
            {{ build.district_address }}
          </a-descriptions-item>
          <a-descriptions-item label="街道办名称">
            {{ build.street_address }}
          </a-descriptions-item>
          <a-descriptions-item label="街道办地址">
            {{ build.street_address_address }}
          </a-descriptions-item>
          <a-descriptions-item label="居委会名称">
            {{ build.committee_name }}
          </a-descriptions-item>
          <a-descriptions-item label="居委会地址">
            {{ build.committee_address }}
          </a-descriptions-item>
          <a-descriptions-item label="居委会书记">
            {{ build.councilor }}
          </a-descriptions-item>
          <a-descriptions-item label="居委会联系电话">
            {{ build.councilor_phone }}
          </a-descriptions-item>
          <a-descriptions-item label="物业公司名称">
            {{ build.property_company_name }}
          </a-descriptions-item>
          <a-descriptions-item label="物业公司地址">
            {{ build.property_company_address }}
          </a-descriptions-item>
          <a-descriptions-item label="物业公司法人">
            {{ build.property_company_legal_person }}
          </a-descriptions-item>
          <a-descriptions-item label="物业公司联系电话">
            {{ build.property_company_phone }}
          </a-descriptions-item>
          <a-descriptions-item label="物业公司联系人">
            {{ build.property_company_contact }}
          </a-descriptions-item>
          <a-descriptions-item label="业主委员会名称">
            {{ build.build_committee_name }}
          </a-descriptions-item>
          <a-descriptions-item label="业主委员会地址">
            {{ build.build_committee_address }}
          </a-descriptions-item>
          <a-descriptions-item label="业主委员会主任">
            {{ build.build_committee_chairman }}
          </a-descriptions-item>
          <a-descriptions-item label="业主委员会联系电话">
            {{ build.build_committee_phone }}
          </a-descriptions-item>
          <a-descriptions-item label="业主委员会联系人">
            {{ build.build_committee_contact }}
          </a-descriptions-item>
          <a-descriptions-item label="业主委员会联系人电话">
            {{ build.build_committee_contact_phone }}
          </a-descriptions-item>
          <a-descriptions-item label="项目介绍人">
            {{ build.project_introducer }}
          </a-descriptions-item>
          <a-descriptions-item label="项目介绍人电话">
            {{ build.project_introducer_phone }}
          </a-descriptions-item>
          <a-descriptions-item label="房屋类型">
            {{ build.house_type }}
          </a-descriptions-item>
          <a-descriptions-item label="住宅数">
            {{ build.households_num }}
          </a-descriptions-item>
          <a-descriptions-item label="商业数">
            {{ build.commercials_num }}
          </a-descriptions-item>
          <a-descriptions-item label="仓库数">
            {{ build.warehouses_num }}
          </a-descriptions-item>
          <a-descriptions-item label="停车位数">
            {{ build.parking_num }}
          </a-descriptions-item>
          <a-descriptions-item label="建筑面积">
            {{ build.building_area }}
          </a-descriptions-item>
          <a-descriptions-item label="土地面积">
            {{ build.land_area }}
          </a-descriptions-item>
          <a-descriptions-item label="建筑总面积">
            {{ build.total_area }}
          </a-descriptions-item>
          <a-descriptions-item label="土地总面积">
            {{ build.land_total_area }}
          </a-descriptions-item>
          <a-descriptions-item label="土地性质">
            {{ build.land_nature }}
          </a-descriptions-item>
          <a-descriptions-item label="项目主体单位名称">
            {{ build.project_unit_name }}
          </a-descriptions-item>
          <a-descriptions-item label="项目主体单位地址">
            {{ build.project_unit_address }}
          </a-descriptions-item>
          <a-descriptions-item label="项目主体单位法人">
            {{ build.project_unit_legal_person }}
          </a-descriptions-item>
          <a-descriptions-item label="项目主体单位联系电话">
            {{ build.project_unit_phone }}
          </a-descriptions-item>
          <a-descriptions-item label="项目主体单位是否灭失">
            {{ build.project_unit_is_lost }}
          </a-descriptions-item>
          <a-descriptions-item label="项目主体单位法人">
            {{ build.project_unit_legal_person }}
          </a-descriptions-item>
          <a-descriptions-item label="修建时间">
            {{ build.build_time }}
          </a-descriptions-item>
          <a-descriptions-item label="竣工时间">
            {{ build.completion_time }}
          </a-descriptions-item>
          <a-descriptions-item label="项目主体单位法人">
            {{ build.project_unit_legal_person }}
          </a-descriptions-item>
          <a-descriptions-item label="项目主体灭失原因">
            {{ build.lost_reason }}
          </a-descriptions-item>
          <a-descriptions-item label="项目承建商名称">
            {{ build.project_builder_name }}
          </a-descriptions-item>
          <a-descriptions-item label="项目承建商地址">
            {{ build.project_builder_address }}
          </a-descriptions-item>
          <a-descriptions-item label="项目承建商法人">
            {{ build.project_builder_legal_person }}
          </a-descriptions-item>
          <a-descriptions-item label="项目承建商联系电话">
            {{ build.project_builder_phone }}
          </a-descriptions-item>
          <a-descriptions-item label="项目承建商是否灭失">
            {{ build.project_builder_is_lost }}
          </a-descriptions-item>
          <a-descriptions-item label="项目承建商灭失原因">
            {{ build.project_builder_lost_reason }}
          </a-descriptions-item>
          <a-descriptions-item label="项目附加信息">
            {{ build.project_additional_information }}
          </a-descriptions-item>
        </a-descriptions>
        <a-descriptions
            style="margin-top:10px;"
            :column="{ xxl: 4, xl: 3, lg: 3, md: 3, sm: 2, xs: 1 }"
            bordered
            title="附件信息"
        >
          <!--          -->
          <a-descriptions-item :span="6" label="项目批复文件">
            <img v-for="(img,index) in build.project_approval_document" :key="index" :src="img"
                 alt="" style="width:150px;height:150px;margin:10px;">
          </a-descriptions-item>

          <a-descriptions-item :span="6" label="土地批复文件">
            <img v-for="(img,index) in build.land_approval_documents" :key="index" :src="img"
                 alt="" style="width:150px;height:150px;margin:10px;">
          </a-descriptions-item>

          <a-descriptions-item :span="6" label="规划建设许可证">
            <img v-for="(img,index) in build.planning_construction_permits" :key="index" :src="img"
                 alt="" style="width:150px;height:150px;margin:10px;">
          </a-descriptions-item>

          <a-descriptions-item :span="6" label="施工许可证">
            <img v-for="(img,index) in build.construction_permit" :key="index" :src="img"
                 alt="" style="width:150px;height:150px;margin:10px;">
          </a-descriptions-item>

          <a-descriptions-item :span="6" label="消防验收报告">
            <img v-for="(img,index) in build.fire_acceptance_report" :key="index" :src="img"
                 alt="" style="width:150px;height:150px;margin:10px;">
          </a-descriptions-item>
          <a-descriptions-item :span="6" label="联合验收报告">
            <img v-for="(img,index) in build.joint_acceptance_report" :key="index" :src="img"
                 alt="" style="width:150px;height:150px;margin:10px;">
          </a-descriptions-item>
          <a-descriptions-item :span="6" label="施工图纸审批文件">
            <img v-for="(img,index) in build.construction_drawing_examination_approval_documents" :key="index"
                 :src="img"
                 alt="" style="width:150px;height:150px;margin:10px;">
          </a-descriptions-item>
          <a-descriptions-item :span="6" label="环保审核文件">
            <img v-for="(img,index) in build.environmental_audit_file" :key="index" :src="img"
                 alt="" style="width:150px;height:150px;margin:10px;">
          </a-descriptions-item>
          <a-descriptions-item :span="6" label="项目竣工图">
            <img v-for="(img,index) in build.project_completion_figure" :key="index" :src="img"
                 alt="" style="width:150px;height:150px;margin:10px;">
          </a-descriptions-item>

        </a-descriptions>
      </div>
    </template>

  </div>
</template>

<script>
export default {
  path: `admin/build/:id/show`,
  data() {
    return {
      id: this.$route.params.id,
      build: {},
      user: JSON.parse(localStorage.getItem('user'))
    }
  },
  created() {
    this.getBuild()
    // let id = this.$watermark.set(this.user.name + '-' + this.user.mobile.substr(7), this.$refs.content)
    // //离开当前页面时，删除水印
    // this.$router.beforeEach((to, from, next) => {
    //   this.$watermark.remove(id)
    //   next()
    // })
  },
  methods: {
    async getBuild() {
      this.build = await this.axios.get(`admin/build/${this.id}`)
    }
  }
}
</script>

<style scoped>

</style>
