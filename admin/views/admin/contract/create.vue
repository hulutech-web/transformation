<template>
  <div>
    <a-card title="合同管理">
      <a-form-model :model="formState"
                    ref="ruleForm"
                    :rules="rules">
        <a-row :gutter="[16,16]">
          <a-col :span="12">
            <a-form-model-item  label="合同编号" prop="uuid">
              <span style="margin:0 5px;">{{ formState.uuid }}</span>
              <a-button type="primary" size="small" @click="makeBarCode" v-if="!formState.uuid">生成编码</a-button>
              <section class="code-box-code-copy">
                <a-tooltip>
                  <template slot="title">
                    复制
                  </template>
                  <a-icon type="copy" v-if="formState.uuid" v-copy="formState.uuid"/>
                </a-tooltip>
              </section>

            </a-form-model-item>

          </a-col>
          <a-col :span="12">
            <a-form-model-item label="住户" props="owner_id">
              <a-input v-model="formState.owner_id" hidden></a-input>
              <a-tag color="#87d068" v-if="formState.owner_name">
                {{ formState.owner_name }}
              </a-tag>
              <a-button type="primary" size="small" @click="openOwner">选择</a-button>
            </a-form-model-item>
          </a-col>

        </a-row>
        <a-row :gutter="[16,16]">
          <a-col :span="8">

            <a-form-model-item label="委托人姓名" prop="principal_name">
              <a-input v-model="formState.principal_name"/>
            </a-form-model-item>
            <a-form-model-item label="委托人电话" prop="principal_phone">
              <a-input v-model="formState.principal_phone"/>
            </a-form-model-item>
            <a-form-model-item label="委托人身份证号" prop="principal_idNo">
              <a-input v-model="formState.principal_idNo"/>
            </a-form-model-item>
            <a-form-model-item label="委托人2姓名" prop="principal_add_name">
              <a-input v-model="formState.principal_add_name"/>
            </a-form-model-item>
          </a-col>
          <a-col :span="8">
            <a-form-model-item label="委托人2电话" prop="principal_add_phone">
              <a-input v-model="formState.principal_add_phone"/>
            </a-form-model-item>
            <a-form-model-item label="委托人2身份证号" prop="principal_add_idNo">
              <a-input v-model="formState.principal_add_idNo"/>
            </a-form-model-item>
            <a-form-model-item label="房屋地址" prop="home_address">
              <a-input v-model="formState.home_address"/>
            </a-form-model-item>
            <a-form-model-item label="代理费" prop="agency_fee">
              <a-input-number style="width:100%;" :min="0" v-model="formState.agency_fee"/>
            </a-form-model-item>
            <a-form-model-item label="一次性费用" prop="one_time_charges">
              <a-input-number style="width:100%;" :min="0" v-model="formState.one_time_charges"/>
            </a-form-model-item>
          </a-col>
          <a-col :span="8">
            <a-form-model-item label="剩余费用" prop="rest">
              <a-input-number style="width:100%" :min="0" v-model="formState.rest"/>
            </a-form-model-item>

            <a-form-model-item label="原土地性质" prop="nature_the_land">
              <a-select style="width: 100%;" v-model="formState.nature_the_land">
                <a-select-option :value="opt" v-for="(opt,index) in options" :key="index">
                  {{ opt }}
                </a-select-option>
              </a-select>
            </a-form-model-item>
            <a-form-model-item label="变更为土地性质" prop="replace_land">
              <a-select style="width: 100%;" v-model="formState.replace_land">
                <a-select-option :value="option" v-for="(option,ind) in options" :key="ind">
                  {{ option }}
                </a-select-option>
              </a-select>
            </a-form-model-item>

            <a-form-model-item label="下差费用" prop="difference_cost">
              <a-input-number style="width:100%;" :min="0" v-model="formState.difference_cost"/>
            </a-form-model-item>

          </a-col>
        </a-row>
        <a-row :gutter="[16,16]">
          <a-col :span="24">
            <a-form-model-item label="补充条款" prop="supplementary_provision">
              <a-textarea :rows="4" v-model="formState.supplementary_provision"/>
            </a-form-model-item>
          </a-col>
        </a-row>
        <a-row :gutter="[16,16]">
          <a-col :span="24">
            <a-button type="primary" @click="onSubmit">提交</a-button>
          </a-col>
        </a-row>
      </a-form-model>

      <!--      抽屉部分-->
      <a-drawer
          title="选择住户"
          :width="480"
          :visible="visible"
          :body-style="{ paddingBottom: '80px' }"
          @close="onClose"
      >
        <a-input-search placeholder="模糊查询，住户名" v-model="keywords" enter-button @search="getRemoteOwners"/>
        <a-table :dataSource="dataSource.data" :pagination="false" :columns="columns" rowKey="id" size="small" bordered>
          <template slot="operation" slot-scope="text,record">
            <a-button type="primary" @click="select(record)" size="small">选择</a-button>
          </template>
        </a-table>
        <a-pagination v-if="dataSource.meta && dataSource.meta.total>dataSource.meta.per_page" :defaultCurrent='1'
                      :total="dataSource.meta.total"
                      :pageSize="dataSource.meta.per_page"
                      @change="getRemoteOwners">
        </a-pagination>

      </a-drawer>
    </a-card>
  </div>
</template>

<script>

const columns = [
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

const options = [
  '集体土地', '国有土地', '划拨', '出让'
]
const rules = {
  uuid: [
    {required: true, message: '合同编号', trigger: 'change'},
  ],
  owner_id: [{required: true, message: '请添加房主', trigger: 'change'}],
  principal_name: [{required: true, message: '请填写介绍人', trigger: 'change'}],
  home_address: [{required: true, message: '请填写房屋地址', trigger: 'change'}],
  principal_idNo: [{
    required: true, message: '请填写身份证号', trigger: 'change',
    //验证身份证
    validator: (rule, value, callback) => {
      if (!value) {
        callback(new Error('请填写身份证号'))
      } else {
        //验证身份证格式
        if (!/^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/.test(value)) {
          callback(new Error('请填写正确的身份证号'))
        } else {
          callback()
        }
      }
    }
  }],
  principal_phone: [{required: true, message: '行政管辖区域', trigger: 'change'}],

  agency_fee: [
    {required: true, message: '代理费用', trigger: 'change'},
  ],
  nature_the_land: [{required: true, message: '请选择原土地性质', trigger: 'change'}],
  replace_land: [{required: true, message: '请选择现土地性质', trigger: 'change'}],
}
const formState = {
  uuid: null,
  principal_name: null,
  principal_phone: null,
  principal_idNo: null,
  principal_add_name: null,
  principal_add_phone: null,
  principal_add_idNo: null,
  home_address: null,
  agency_fee: null,
  one_time_charges: null,
  rest: null,
  nature_the_land: null,
  replace_land: null,
  difference_cost: null,
  supplementary_provision: null,
  owner_id: null
}
export default {
  data() {
    return {
      formState,
      rules: rules,
      options,
      visible: false,
      keywords: '',
      dataSource: [],
      columns,
      img: null,
    }
  },
  methods: {
    validate() {
      this.$refs.ruleForm.validate(valid => {
        if (valid) {
          this.$emit('isValidateHandle', true)

          return true
        } else {
          console.log('error submit!!');
          this.$emit('isValidateHandle', false)
          return false;
        }
      });
    },
    //生成编码
    async makeBarCode() {
      this.formState.uuid = await this.axios.post('admin/contract/getUuid')
    },
    onSubmit() {
      this.$refs.ruleForm.validate(async valid => {
        if (valid) {
          this.$emit('isValidateHandle', true)
          await this.axios.post("admin/contract", this.formState)
          //清空formState
          this.formState = {}
          this.formState = this.$options.data().formState
          return true
        } else {
          console.log('error submit!!');
          this.$emit('isValidateHandle', false)
          return false;
        }
      });
    },
    async getRemoteOwners(page = 0) {
      this.dataSource = await this.axios.post(`admin/owner/filterOwner?page=${page}`, {keywords: this.keywords})
    },
    openOwner() {
      this.visible = true
      this.getRemoteOwners()
    },
    onClose() {
      this.visible = false
    },
    select(record) {
      this.visible = false
      this.formState.owner_id = record.id
      this.formState.owner_name = record.householder_name
    }
  }
}
</script>

<style scoped>

</style>
