<template>
  <div>
    <a-card title="報告列表">

      <a-table :dataSource="carReports" rowKey="id" :columns="columns">
        <template slot="repair" slot-scope="text,record">
          <span v-for="(item, index) in record.repair_project" :key="index">{{ item.value }}</span>
        </template>
        <template slot="attachment" slot-scope="text,record">
          <img alt="" style="width:40px;" v-for="(img, index) in record.attachment" :key="index" :src="img">
        </template>
        <template slot="action" slot-scope="text,record">
          <a-button type="primary" @click="exportPdf(record)">轉PDF</a-button>
        </template>
      </a-table>
    </a-card>

  </div>
</template>

<script>
const columns = [
  {
    title: '公司名稱',
    dataIndex: 'company_name',
    key: 'company_name',
  },
  {
    title: '日期',
    dataIndex: 'report_date',
    key: 'report_date',
  },
  {
    title: '車牌',
    dataIndex: 'car_number',
    key: 'car_number',
  },
  {
    title: '車型',
    dataIndex: 'car_type',
    key: 'car_type',
  },
  {
    title: '汽車品牌',
    dataIndex: 'car_brand',
    key: 'car_brand',
  },
  {
    title: '行車公里數',
    dataIndex: 'mileage',
    key: 'mileage',
  },
  {
    title: '費用合計',
    dataIndex: 'total_cost',
    key: 'total_cost',
  },
  {
    title: '維修項目',
    dataIndex: 'repair_project',
    key: 'repair_project',
    scopedSlots: {customRender: 'repair'},
  },
  {
    title: '附件',
    dataIndex: 'attachment',
    key: 'attachment',
    scopedSlots: {customRender: 'attachment'},
  },
  {
    title: '操作',
    dataIndex: 'action',
    key: 'action',
    scopedSlots: {customRender: 'action'},
  },
]
export default {
  data() {
    return {
      carReports: [],
      columns: columns,
    }
  },
  created() {
    this.getCarReports()
  },
  methods: {
    async getCarReports() {
      this.carReports = await this.axios.get('admin/carreport')
    },
    async exportPdf(record) {
      await this.axios.post(`admin/carreport/${record.id}/export`, record)
    }
  }
}
</script>

<style scoped>
</style>