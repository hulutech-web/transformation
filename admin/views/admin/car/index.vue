<template>
  <div>
    <a-card title="報告列表" size="small">
      <template #extra>
        <a-input-search v-model="keyword" placeholder="请输入公司关键字" enter-button @search="searchReport"></a-input-search>
      </template>
      <a-table bordered :pagination="false" size="small" :dataSource="carReports.data" rowKey="id" :columns="columns">

        <template slot="action" slot-scope="text,record">
          <a-button type="primary" size="small" @click="exportPdf(record)" icon="download">预览</a-button>
          <a-button type="primary" size="small" @click="show(record)">查看</a-button>
          <a-button type="danger" size="small" @click="deleteRecord(record)">删除</a-button>
        </template>
      </a-table>
      <a-pagination v-if="carReports.total>carReports.per_page" :defaultCurrent='1' :total="carReports.total"
                    :pageSize="carReports.per_page"
                    @change="getCarReports">
      </a-pagination>
    </a-card>
  </div>
</template>

<script>
const columns = [
  {
    title: '公司名稱',
    dataIndex: 'company_name',
    key: 'company_name',
    width: 80
  },
  {
    title: '日期',
    dataIndex: 'report_date',
    key: 'report_date',
    width: 100
  },
  {
    title: '車牌',
    dataIndex: 'car_number',
    key: 'car_number',
    width: 80,
  },
  {
    title: '品牌',
    dataIndex: 'car_brand',
    key: 'car_brand',
    width: 80,
  },
  {
    title: '費用合計',
    dataIndex: 'total_cost',
    key: 'total_cost',
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
      keyword: null,
    }
  },
  created() {
    this.getCarReports()
  },
  methods: {
    async getCarReports(page = 1) {
      this.carReports = await this.axios.get(`admin/carreport?page=${page}`)
    },
    exportPdf(record) {
      window.open(`/carreport/${record.id}/exportpdf`)
    },
    show(record) {
      this.$router.push({path: `/admin/car/${record.id}/show`})
    },
    async searchReport() {
      this.carReports = await this.axios.post("admin/carreport/searchCarReport", {keyword: this.keyword})
    },
    deleteRecord(record) {
      this.$confirm({
        title: '确认删除',
        content: '确认删除该報告吗？',
        okText: '确认',
        cancelText: '取消',
        onOk: async () => {
          await this.axios.delete(`admin/carreport/${record.id}`)
          await this.getCarReports()
        },
      })
    }
  }
}
</script>

<style scoped>
</style>