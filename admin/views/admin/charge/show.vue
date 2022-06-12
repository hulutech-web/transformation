<template>
  <div>
    <a-card title="充電樁檢查報告">
      <a-descriptions title="報告詳情" layout="vertical" bordered v-if="chargingReport.id">
        <a-descriptions-item label="報告時間">
          {{ chargingReport.report_date }}
        </a-descriptions-item>
        <a-descriptions-item label="停車場">
          {{ chargingReport.park_name }}
        </a-descriptions-item>
        <a-descriptions-item label="填報人">
          {{ chargingReport.user_name }}
        </a-descriptions-item>
        <a-descriptions-item label="備註">
          {{ chargingReport.remark }}
        </a-descriptions-item>
        <a-descriptions-item label="停車位" :span="2">
          <a-tag v-for="(c,index) in chargingReport.stalls" :key="index">{{ c }}</a-tag>
        </a-descriptions-item>
        <a-descriptions-item label="充電樁" :span="3">
          <a-list size="small" item-layout="horizontal" :data-source="chargingReport.chargingPiles">
            <a-list-item slot="renderItem" slot-scope="item, index">
              <a-list-item-meta
                  :description="`設備ID：${item.id}`"
              >
              </a-list-item-meta>
              <p>設變號：{{ item.device_id }}</p>
              <p>編號：{{ item.model }}</p>
              <p>品牌：{{ item.brand }}</p>
            </a-list-item>
          </a-list>
        </a-descriptions-item>

        <a-descriptions-item label="報告結果" v-for="(item,i) in chargingReport.chargingResults" :key="i">
          <div>
            設備id:{{ item.result.device_id }}
            <br/>
            <div v-for="(re,index) in item.result.resultData" :key="index">
              <span v-if="index==0" style="font-weight: bold">1:IECACT Type 2</span>
              <span v-if="index==1" style="font-weight: bold">2:CCS Combo 2</span>
              <span v-if="index==2" style="font-weight: bold">3:CHAdeMO</span>
              <span v-if="index==3" style="font-weight: bold">4:充电椿</span>
              <span v-for="(f,ind) in re.field_options" :key="ind" style="display:flex;justify-content: space-between">
                {{ f.field_id }}:{{ f.field_name }}:{{ f.value }}
              </span>
            </div>
          </div>
        </a-descriptions-item>
      </a-descriptions>
    </a-card>
  </div>
</template>

<script>
export default {
  path: '/admin/charge/:id/show',
  data() {
    return {
      id: this.$route.params.id,
      chargingReport: {}
    }
  },
  created() {
    this.getChargeReport()
  },
  methods: {
    async getChargeReport() {
      this.chargingReport = await this.axios.get(`admin/chargingreport/${this.id}/show`)
    },
  }
}
</script>

<style scoped>

</style>