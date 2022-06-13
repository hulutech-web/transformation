<template>
  <div>
    <a-card title="汽車報告詳情">
      <a-descriptions title="報告詳情" bordered>
        <a-descriptions-item label="報告日期">
          {{ carReport.report_date }}
        </a-descriptions-item>
        <a-descriptions-item label="公司名稱">
          {{ carReport.company_name }}
        </a-descriptions-item>
        <a-descriptions-item label="汽車編號">
          {{ carReport.car_number }}
        </a-descriptions-item>
        <a-descriptions-item label="汽車類型">
          {{ carReport.car_type }}
        </a-descriptions-item>
        <a-descriptions-item label="汽車品牌" :span="2">
          {{ carReport.car_brand }}
        </a-descriptions-item>
        <a-descriptions-item label="行車公里數" :span="2">
          {{ carReport.mileage }}
        </a-descriptions-item>

        <a-descriptions-item label="費用" :span="2">
          {{ carReport.total_cost }}
        </a-descriptions-item>

        <a-descriptions-item label="备注信息" :span="3">
          {{ carReport.remark }}
        </a-descriptions-item>
        
        <a-descriptions-item label="維修項目" :span="3">
          <div v-for="(item,index) in carReport.repair_project" :key="index">
            <span class="dot"></span>{{ item.value }}
          </div>
        </a-descriptions-item>
        <a-descriptions-item label="內容" :span="3">
          <div v-for="(item,index) in carReport.content_brief" :key="index">
            {{ item.title }}：{{ item.value }}
          </div>
        </a-descriptions-item>
        <a-descriptions-item label="附件" :span="3">
          <div v-for="(item,index) in carReport.attachment" :key="index">
            <img :src="item" alt="" style="height:200px;">
          </div>
        </a-descriptions-item>
      </a-descriptions>

    </a-card>
  </div>
</template>

<script>
export default {
  path: '/admin/car/:id/show',
  data() {
    return {
      id: this.$route.params.id,
      carReport: {}
    }
  },
  created() {
    this.getCarReport()
  },
  methods: {
    async getCarReport() {
      this.carReport = await this.axios.get(`admin/carreport/${this.id}`)
    }
  }
}
</script>

<style scoped>
.dot {
  width: 6px;
  height: 6px;
  vertical-align: baseline;
  line-height: 6px;
  background-color: #1890ff;
  border-radius: 50%;
  display: inline-block;
  margin-right: 6px;
}
</style>