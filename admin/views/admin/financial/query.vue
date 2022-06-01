<template>
  <div>
    <a-card>
      <a-card style="margin-top:2px;" title="缴费查询">
        <a-row>
          <a-col :span="12">
            <a-form-model ref="ruleForm" layout="inline" :model="form">
              <a-form-model-item label="业主名" prop="householder_name">
                <a-tag color="#87d068" v-if="form.owner_name">
                  {{ form.owner_name }}
                </a-tag>
                <a-button type="primary" size="small" @click="openOwner">选择</a-button>
              </a-form-model-item>
              <a-form-model-item label="开始时间" prop="start_time">
                <!--默认为当天0点-->
                <a-date-picker
                    v-model="form.start_time"
                    value-format="YYYY-MM-DD HH:mm:ss"
                    show-time
                    :locale="zhCN"
                    placeholder="开始时间"
                />
              </a-form-model-item>
              <a-form-model-item label="结束时间" prop="end_time">
                <!--默认为当天24点-->
                <a-date-picker
                    v-model="form.end_time"
                    value-format="YYYY-MM-DD HH:mm:ss"
                    show-time
                    :locale="zhCN"
                    placeholder="结束时间"
                />
              </a-form-model-item>
              <a-form-model-item style="display: block;">
                <a-button type="primary" @click="onSubmit">查询</a-button>
              </a-form-model-item>
            </a-form-model>
          </a-col>
          <a-col :span="12">
            <a-card>
              本次查询金额汇总：{{ totalAmount }}元
            </a-card>
          </a-col>
        </a-row>

      </a-card>


      <a-card title="缴费历史" style="  margin-top:12px;">
        <a-table :dataSource="dataSource.data" :columns="columns" bordered rowKey="id" :pagination="false">
          <template slot="formatTime" slot-scope="text,record">
            {{ record.created_at | dateFormat() }}
          </template>
          <template slot="operation" slot-scope="text, record">
            <a href="javascript:; " @click="openHistoryOwner(record)">查看历史</a>
          </template>
        </a-table>
        <a-pagination v-if="dataSource.meta && dataSource.meta.total>dataSource.meta.per_page" :defaultCurrent='1'
                      :total="dataSource.meta.total"
                      :pageSize="dataSource.meta.per_page"
                      @change="queryHistory">
        </a-pagination>

        <!--        用户选择弹窗-->


        <a-drawer
            title="选择住户"
            :width="480"
            :visible="ownerVisible"
            :body-style="{ paddingBottom: '80px' }"
            @close="owneronClose"
        >
          <a-input-search placeholder="模糊查询，住户名" v-model="keywords" enter-button @search="getRemoteOwners"/>
          <a-table :dataSource="ownerSource.data" :pagination="false" :columns="onwercolumns" rowKey="id" size="small"
                   bordered>
            <template slot="operation" slot-scope="text,record">
              <a-button type="primary" @click="ownerselect(record)" size="small">选择</a-button>
            </template>
          </a-table>
          <a-pagination
              v-if="ownerSource.meta && ownerSource.meta.total && ownerSource.meta.total>ownerSource.meta.per_page"
              :defaultCurrent='1'
              :total="ownerSource.meta.total"
              :pageSize="ownerSource.meta.per_page"
              @change="getRemoteOwners">
          </a-pagination>

        </a-drawer>

        <!--        弹出end-->

        <!--        历史记录弹窗-->

        <a-drawer
            :title="`历史缴费：${contract_record.home_address}`"
            :width="720"
            :visible="historyVisible"
            :body-style="{ paddingBottom: '80px' }"
            @close="historyonClose"
        >
          <div>
            <a-card title="缴费历史">
              <a-steps progress-dot :current="historyRecords.length">
                <a-step v-for="(h,index) in historyRecords" :key="index" :title="`金额：${h.payment}元`"
                        :description="h.created_at"/>
              </a-steps>
            </a-card>
            <a-card title="缴纳占比">
              <a-progress type="circle"
                          :percent="percent"/>
            </a-card>
          </div>
        </a-drawer>

        <!--        弹出end-->
      </a-card>
    </a-card>
  </div>
</template>

<script>

const columns = [
  {
    title: 'id',
    dataIndex: 'id',
    key: 'id'
  },
  {
    title: '业主姓名',
    dataIndex: 'owner_name',
    key: 'owner_name'
  },
  {
    title: '缴费金额',
    dataIndex: 'payment',
    key: 'payment'
  },
  {
    title: '地址',
    dataIndex: 'home_address',
    key: 'home_address'
  },
  {
    title: '缴费时间',
    dataIndex: 'created_at',
    key: 'created_at',
    scopedSlots: {customRender: 'formatTime'},

  },

  {
    title: '缴前费用',
    dataIndex: 'before_pay',
    key: 'before_pay'
  },
  {
    title: '缴后费用',
    dataIndex: 'after_pay',
    key: 'after_pay',
  },
  {
    title: '详情',
    dataIndex: 'operation',
    key: 'operation',
    scopedSlots: {customRender: 'operation'},
  }

]
const onwercolumns = [
  {
    id: 'id',
    title: '序号',
    key: 'id',
    dataIndex: 'id',
  },
  {
    id: 'build_name',
    title: '楼盘名称',
    key: 'build_name',
    dataIndex: 'build_name',
  },
  {
    id: 'householder_name',
    title: '住户姓名',
    key: 'householder_name',
    dataIndex: 'householder_name',
  },
  {
    id: 'operation',
    title: "操作",
    key: "operation",
    dataIndex: "operation",
    scopedSlots: {
      customRender: 'operation',
    },

  }
]

const ruleForm = {
  create_time: '',
  end_time: '',
  householder_name: '',
}
import zhCN from 'ant-design-vue/lib/locale-provider/zh_CN';
import moment from 'moment'

export default {
  path: '/admin/financial/query',
  data() {
    return {
      ruleForm,
      onwercolumns,
      keywords: '',
      form: {
        start_time: moment().startOf('day').format('YYYY-MM-DD HH:mm:ss'),
        end_time: moment().endOf('day').format('YYYY-MM-DD HH:mm:ss'),
      },
      moment,
      dataSource: {},//缴费记录
      ownerSource: {},//业主列表
      columns,
      historyVisible: false,
      ownerVisible: false,
      zhCN,
      contract_record: {},
      historyRecords: [],
      percent: 0,
    }
  },
  created() {
    this.queryHistory()
  },
  computed: {
    totalAmount() {
      if (this.dataSource.data && this.dataSource.data.length > 0) {
        return this.dataSource.data.reduce((total, item) => {
          return total + item.payment * 1
        }, 0)
      }
    }
  },
  methods: {
    openOwner() {
      this.ownerVisible = true
      this.getRemoteOwners()
    },
    //查看缴费记录
    openHistoryOwner(record) {
      console.log(record)
      this.historyVisible = true
      this.contract_record = record
      //计算百分比，保留2为小数

      this.percent =
          parseFloat(record.after_pay) / parseFloat(record.agency_fee) * 100

      //发送网络请求查找缴费记录
      this.axios.post('admin/contractrecord/allhistory', {contract_id: record.contract_id}).then(_ => {
        this.historyRecords = _
      })
    },
    //获取业主列表
    async getRemoteOwners(page = 1) {
      this.ownerSource = await this.axios.post(`admin/owner/filterOwner?page=${page}`, {keywords: this.keywords})
    },

    //查询历史列表
    async queryHistory(page = 1) {
      this.dataSource = await this.axios.post(`admin/FinancialHistory?page=${page}`, this.form)
    },

    owneronClose() {
      this.ownerVisible = false
    },
    historyonClose() {
      this.historyVisible = false
    },
    async handleSubmit() {
      console.log(this.form)
    },
    //业主选择方法
    ownerselect(record) {
      this.form.owner_id = record.id
      this.form.owner_name = record.householder_name
      this.ownerVisible = false
    },
    async onSubmit() {
      console.log(this.form)
      await this.queryHistory()
    },
  }
}
</script>

<style scoped>
</style>
