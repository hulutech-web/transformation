<template>
  <div style="padding: 20px; background: white; min-height: 100%">
    <div>
      <h1>PDF報表系統</h1>
      <p>
        汽車維修報告管理
      </p>
      <p>
        充電轉報告管理
      </p>
      <p>
        多員工管理
      </p>
      <p>
        多角色配置
      </p>
      <p>
        汽車維修報告EXCEL模板導入
      </p>
      <p>
        充電轉報告EXCEL模板導入
      </p>
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
