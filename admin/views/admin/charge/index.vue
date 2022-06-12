<template>
  <div>
    <a-card title="報告列表">
      <template #extra>
        <a-input-search enter-button></a-input-search>
      </template>
      <a-table :data-source="chargingReports.data" :columns="columns" rowKey="id" bordered :pagination="false">
        <template slot="action" slot-scope="text,record">
          <a-button-group>
            <a-button type="primary" @click="showReport(record)">查看</a-button>
            <a-button type="danger" ghost>刪除</a-button>
            <a-button type="danger" icon="download" @click="makeReport(record)" ghost>生成PDF</a-button>
            <a-button type="primary" @click="test(record)">测试collect</a-button>
          </a-button-group>
        </template>
        <template slot="stall" slot-scope="text,record">
        <span v-for="(item,index) in record.stalls" :key="index">
        <a-tag>{{ item }}</a-tag>
        </span>
        </template>
        <template slot="chargingPiles" slot-scope="text,record">
        <span v-for="(item,index) in record.chargingPiles" :key="index">
        <a-tag>{{ item.device_id }}</a-tag>
        </span>
        </template>

      </a-table>
      <a-pagination v-if="chargingReports.total>chargingReports.per_page" :defaultCurrent='1'
                    :total="chargingReports.total"
                    :pageSize="chargingReports.per_page"
                    @change="getChargingReports">
      </a-pagination>
    </a-card>

  </div>
</template>

<script>
const columns = [
  {
    title: 'ID',
    dataIndex: 'id',
    key: 'id',
    width: 80,
    align: 'center'
  },
  {
    title: '日期',
    dataIndex: 'report_date',
    key: 'report_date',
    align: 'center'
  },
  {
    title: '停車場ID',
    dataIndex: 'park_id',
    key: 'park_id',
    width: 100,
  },
  {
    title: '充电桩',
    dataIndex: 'chargingPiles',
    key: 'chargingPiles',
    align: 'center',
    scopedSlots: {customRender: 'chargingPiles'}
  },
  {
    title: '停車位编号',
    dataIndex: 'stalls',
    key: 'stalls',
    align: 'center',
    scopedSlots: {customRender: 'stall'}
  },
  {
    title: '備註',
    dataIndex: 'remark',
    key: 'remark',
    width: 200,
    align: 'center'
  },
  {
    title: '用戶ID',
    dataIndex: 'user_id',
    key: 'user_id',
    width: 200,
    align: 'center'
  },
  {
    title: '操作',
    key: 'action',
    dataIndex: 'action',
    width: 200,
    align: 'center',
    scopedSlots: {customRender: 'action'}
  },
]
export default {
  data() {
    return {
      chargingReports: [],
      columns,
    }
  },
  created() {
    this.getChargingReports()
  },
  methods: {
    async getChargingReports(page = 1) {
      this.chargingReports = await this.axios.get(`admin/chargingreport?page=${page}`)
    },
    showReport(record) {
      this.$router.push({path: `/admin/charge/${record.id}/show`})
    },
    async makeReport(record) {
      window.open(`/chargingreport/${record.id}/exportpdf`)
    },
    async test(record) {
      this.axios.post(`admin/chargingreport/${record.id}/test`)
    }
  }
}
</script>

<style scoped>

</style>