<template>
  <div>
    <a-card title="報告列表">
      <template #extra>
        <a-input-search placeholder="请输入公司关键字" enter-button></a-input-search>
      </template>
      <a-table bordered :pagination="false" :dataSource="carReports.data" rowKey="id" :columns="columns">

        <template slot="repair" slot-scope="text,record">
          <span v-for="(item, index) in record.repair_project" :key="index">{{ item.value }}</span>
        </template>
        <template slot="attachment" slot-scope="text,record">
          <img alt="" style="width:40px;" v-for="(img, index) in record.attachment" :key="index" :src="img">
        </template>
        <template slot="action" slot-scope="text,record">
          <a-button-group>
            <a-button type="primary" size="small" @click="exportPdf(record)" icon="download">生成PDF</a-button>
            <a-button type="primary" size="small" @click="show(record)">查看</a-button>
            <a-button type="danger" size="small" @click="deleteRecord(record)">删除</a-button>
          </a-button-group>
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
    width: 100
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
    width: 150,
  },
  {
    title: '費用合計',
    dataIndex: 'total_cost',
    key: 'total_cost',
    width: 100,
  },
  {
    title: '維修項目',
    dataIndex: 'repair_project',
    key: 'repair_project',
    scopedSlots: {customRender: 'repair'},
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
    async getCarReports(page = 1) {
      this.carReports = await this.axios.get(`admin/carreport?page=${page}`)
    },
    exportPdf(record) {
      window.open(`/carreport/${record.id}/exportpdf`)
    },
    show(record) {
      this.$router.push({path: `/admin/car/${record.id}/show`})
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