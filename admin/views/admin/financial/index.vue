<template>
  <div>
    <a-card title="合同列表">
      <template #extra>
        <a-input-search enter-button placeholder="请输入业主姓名" v-model="keyword" @search="onSearch"></a-input-search>
      </template>
      <a-table :dataSource="contracts.data" :columns="columns" bordered rowKey="id" :pagination="false">
        <template slot="operation" slot-scope="text, record">
          <a href="javascript:; " @click="pay(record)">费用缴纳</a>
        </template>
      </a-table>
      <a-pagination v-if="contracts.total>contracts.per_page" :defaultCurrent='1' :total="contracts.total"
                    :pageSize="contracts.per_page"
                    @change="getFinancialContracts">
      </a-pagination>
    </a-card>

    <!--        弹出-->

    <a-drawer
        title="缴费管理"
        :width="720"
        :visible="visible"
        :body-style="{ paddingBottom: '80px' }"
        @close="onClose"
    >

      <a-form :form="formState" layout="vertical" hide-required-mark>
        <a-row :gutter="16">
          <a-col :span="8">
            <a-form-item label="所有人">
              <a-input
                  disabled
                  v-decorator="[
                  'owner_name',
                  {
                    rules: [{ required: true, message: '所有人' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入所有人"
              />
            </a-form-item>

          </a-col>
          <a-col :span="8">
            <a-form-item label="房屋地址">
              <a-input
                  disabled
                  v-decorator="[
                  'home_address',
                  {
                    rules: [{ required: true, message: '房屋地址' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入房屋地址"
              />
            </a-form-item>
          </a-col>


          <a-col :span="8">
            <a-form-item label="原土地性质">
              <a-input
                  disabled
                  v-decorator="[
                  'nature_the_land',
                  {
                    rules: [{ required: true, message: '原土地性质' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入原土地性质"
              />
            </a-form-item>
          </a-col>


          <a-col :span="8">
            <a-form-item label="现土地性质">
              <a-input
                  disabled
                  v-decorator="[
                  'replace_land',
                  {
                    rules: [{ required: true, message: '现土地性质' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入现土地性质"
              />
            </a-form-item>
          </a-col>
          <a-col :span="8">
            <a-form-item label="代理费">
              <a-input
                  disabled
                  v-decorator="[
                  'agency_fee',
                  {
                    rules: [{ required: true, message: '代理费' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入代理费"
              />
            </a-form-item>

          </a-col>
          <a-col :span="8">
            <a-form-item label="一次性费用">
              <a-input
                  disabled
                  v-decorator="[
                  'one_time_charges',
                  {
                    rules: [{ required: true, message: '一次性费用' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入一次性费用"
              />
            </a-form-item>

          </a-col>

          <a-col :span="8">
            <a-form-item label="下差费用">
              <a-input
                  disabled
                  v-decorator="[
                  'difference_cost',
                  {
                    rules: [{ required: true, message: '下差费用' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入下差费用"
              />
            </a-form-item>
          </a-col>

          <a-col :span="24">
            <a-form-item label="本次缴纳">
              <a-input-number
                  :min="0"
                  v-decorator="[
                  'currentPayment',
                  {
                    rules: [{ required: true, message: '请输入数字' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入缴纳费用"
              />
            </a-form-item>
          </a-col>

        </a-row>

      </a-form>
      <div
          :style="{
          position: 'absolute',
          right: 0,
          bottom: 0,
          width: '100%',
          borderTop: '1px solid #e9e9e9',
          padding: '10px 16px',
          background: '#fff',
          textAlign: 'right',
          zIndex: 1,
        }"
      >
        <a-button type="primary" @click="onClose">
          取消
        </a-button>
        <a-button type="primary" @click="handleSubmit">
          提交
        </a-button>
      </div>
    </a-drawer>

    <!--        弹出end-->
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
    title: '房屋地址',
    dataIndex: 'home_address',
    key: 'home_address'
  },
  {
    title: '原土地性质',
    dataIndex: 'nature_the_land',
    key: 'nature_the_land'
  },
  {
    title: '现土地性质',
    dataIndex: 'replace_land',
    key: 'replace_land'
  },
  {
    title: '代理费',
    dataIndex: 'agency_fee',
    key: 'agency_fee'
  },
  {
    title: '一次性费用',
    dataIndex: 'one_time_charges',
    key: 'one_time_charges'
  },
  {
    title: '下差费用',
    dataIndex: 'difference_cost',
    key: 'difference_cost'
  },
  {
    title: '操作',
    dataIndex: 'operation',
    key: 'operation',
    scopedSlots: {customRender: 'operation'},
  }
]
export default {
  data() {
    return {
      visible: false,
      keyword: '',
      columns,
      currentPayment: 0,
      contract_id: '',
      contracts: [],
      user: JSON.parse(localStorage.getItem('user')),
    }
  },
  beforeCreate() {
    this.formState = this.$form.createForm(this);
  },
  created() {
    this.getFinancialContracts()
  },
  methods: {
    //财务可查合同列表
    async getFinancialContracts(page = 1) {
      this.contracts = await this.axios.post(`admin/contract/finance?page=${page}`)
    },
    async onSearch() {
      this.contracts = await this.axios.post(`admin/user/${this.user.id}/contract/getOwnerContract`, {keyword: this.keyword})
    },
    async pay(record) {
      this.visible = true
      this.contract_id = record.id

      this.$nextTick(() => {
        this.formState.setFieldsValue({
          owner_name: record.owner_name,
          home_address: record.home_address,
          nature_the_land: record.nature_the_land,
          one_time_charges: record.one_time_charges,
          replace_land: record.replace_land,
          agency_fee: record.agency_fee,
          difference_cost: record.difference_cost,
          currentPayment: record.currentPayment,
        });
      })
    },
    onClose() {
      this.visible = false
      this.formState.resetFields();
    },
    handleSubmit() {
//验证
      this.formState.validateFields(async (err, values) => {
        if (!err) {
          console.log(values)
          this.axios.post(`admin/contract/${this.contract_id}/putFinancialPayment`, {payment: values.currentPayment}).then(res => {
            this.visible = false
            this.formState.resetFields();
            this.getFinancialContracts()
          })
        }
      });
    },
  }

}
</script>

<style scoped>

</style>