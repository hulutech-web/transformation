<template>
  <div style="padding: 20px; background: white; min-height: 100%">
    <div style="background-color: #ececec; padding: 20px;">
      <a-row :gutter="[16,16]">
        <a-col :span="4">
          <a-card class="card_center">
            <section class="dashboard_content">1</section>
            <p class="dashboard_title">楼盘总数</p>
          </a-card>
        </a-col>

        <a-col :span="4">
          <a-card class="card_center">
            <section class="dashboard_content">2</section>
            <p class="dashboard_title">楼盘业主数</p>
          </a-card>
        </a-col>
        <a-col :span="4">
          <a-card class="card_center">
            <section class="dashboard_content">3</section>
            <p class="dashboard_title">合同总数</p>
          </a-card>
        </a-col>
        <a-col :span="4">
          <a-card class="card_center">
            <section class="dashboard_content">￥333333</section>
            <p class="dashboard_title">合同总金额:333333</p>
          </a-card>
        </a-col>
        <a-col :span="4">
          <a-card class="card_center">
            <section class="dashboard_content">￥3333</section>
            <p class="dashboard_title">首付费用:333</p>
          </a-card>
        </a-col>
        <a-col :span="4">
          <a-card class="card_center">
            <section class="dashboard_content">333</section>
            <p class="dashboard_title">q24351234</p>
          </a-card>
        </a-col>
      </a-row>
    </div>
    <div>

      <a-card>
        <a-row :gutter="[16,16]">
          <a-col :span="8">
            <a-card>
              <p class="dashboard_content">财务</p>
              <PieChart :pieData="pieData"/>
            </a-card>
          </a-col>
          <a-col :span="8">
            <a-card>

              <p class="dashboard_content">变更土地</p>
              <PieChart :pieData="replaceData"/>
            </a-card>
          </a-col>
          <a-col :span="8">
            <a-card>

              <p class="dashboard_content">原始土地</p>
              <PieChart :pieData="cateData"/>
            </a-card>
          </a-col>
        </a-row>
        <a-row :gutter="[16,16]">


        </a-row>
      </a-card>
    </div>
    <div>
      <a-card>
        <a-descriptions title="其他信息">

          <a-descriptions-item label="系统用户">
            123名
          </a-descriptions-item>
          <a-descriptions-item label="已办理">
            123户
          </a-descriptions-item>
          <a-descriptions-item label="待办理">
            1321户
          </a-descriptions-item>
        </a-descriptions>
      </a-card>

    </div>

  </div>
</template>


<script>
import LineChart from "#/components/Charts/LineChart";
import PieChart from "#/components/Charts/PieChart";

export default {
  components: {
    LineChart,
    PieChart
  },
  meta: {
    title: "首页",
  },
  data() {
    return {
      formData: {},
      lineData: {},
      pieData: {},
      cateData: {},
      replaceData: {},
      roles: this.$store.state.roles
    }
  },
  created() {
    // this.getData()
    this.bootstrap()
  },
  methods: {
    async getData() {
      this.formData = await this.axios.post('admin/home')

      this.pieData = {           //按性别分类的歌手数
        columns: ['费用', '金额'],
        rows: [
          {'费用': '一次性费用', '金额': this.formData.total_one_time_charges},
          {'费用': '剩余费用', '金额': this.formData.total_rest_fee},
        ]
      }
      this.cateData = {
        columns: ['类型', '数量'],
        rows: this.formData.nature_the_land.map(item => {
          return {
            '类型': item.nature_the_land,
            '数量': item.total
          }
        })
      }
      this.replaceData = {
        columns: ['类型', '数量'],
        rows: this.formData.replace_land.map(item => {
          return {
            '类型': item.replace_land,
            '数量': item.total
          }
        })
      }
    },
    async bootstrap() {
      await this.axios.post('admin/home/bootstrap')
    }
  }

}
</script>
<style lang="scss" scoped>
.card_center {
  text-align: center;
}


.dashboard_content {
  font-size: 22px;
  font-weight: bold;
  color: #333;
}
</style>
