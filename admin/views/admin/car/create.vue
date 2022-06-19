<template>
  <div>
    <a-card title="汽車維修報告">
      <a-form-model ref="ruleForm" :model="form" :rules="rules">
        <a-row :gutter="[16, 16]">
          <a-col :span="12">
            <a-form-model-item required label="公司名稱(搜索)" prop="company_name">
              <Search :value="form.company_name" width="100%" :searchForm="form" :url="url"
                      @changeValue="changeValue"/>
            </a-form-model-item>
          </a-col>
          <a-col :span="12">
            <a-form-model-item label="日期" required prop="report_date">
              <a-date-picker :default-value="moment(new Date().toLocaleDateString(), 'YYYY-MM-DD')"
                             valueFormat="YYYY-MM-DD" v-model="form.report_date" type="date" placeholder="請輸入日期"
                             style="width: 100%;"/>
            </a-form-model-item>
          </a-col>
          <a-col :span="12">
            <a-form-model-item required label="車牌編號" prop="car_number">
              <a-input v-model="form.car_number" placeholder="請輸入車牌編號"/>
            </a-form-model-item>
          </a-col>
          <a-col :span="12">
            <a-form-model-item ref="car_type" required label="車型" prop="car_type">
              <a-input v-model="form.car_type"/>
            </a-form-model-item>
          </a-col>
          <a-col :span="12">
            <a-form-model-item ref="car_brand" required label="汽車品牌" prop="car_brand">
              <a-input v-model="form.car_brand"/>
            </a-form-model-item>
          </a-col>
          <a-col :span="12">
            <a-form-model-item label="行車公里數" prop="mileage" required>
              <a-input-number :min="0" v-model="form.mileage" style="width:100%;"></a-input-number>
            </a-form-model-item>
          </a-col>
        </a-row>
        <a-form-model-item :label="index > 0 ? `項目${index}` : `檢查保養維修項目`" v-for="(item, index) in form.repair_project"
                           :key="index" :rules="{
            required: true,
            message: '保養項目不能為空',
            trigger: 'blur',
          }" props="repair_project">
          <a-input v-model="item.value" placeholder="請輸入內容" style="width: 60%; margin-right: 8px"/>
          <a-icon v-if="form.repair_project.length > 1" class="dynamic-delete-button" type="minus-circle-o"
                  :disabled="form.repair_project.length === 1" @click="removeItem(item)"/>
        </a-form-model-item>
        <a-form-model-item v-bind="formItemLayoutWithOutLabel">
          <a-button type="dashed" style="width: 80%;" @click="addItem">
            <a-icon type="plus"/>
            添加項目
          </a-button>
        </a-form-model-item>

        <a-form-model-item label="費用合計" prop="total_cost">
          <a-input-number :min="0" v-model="form.total_cost"></a-input-number>
        </a-form-model-item>

        <a-form-model-item label="內容簡報" prop="content_brief" v-if="carreportItem.length > 0">
          <div v-for="(item, ind) in carreportItem" :key="ind" class="list">
            <span style="padding-left:10px;">{{ item.title }}</span>
            <a-radio-group class="list_group" @change="radioChange" v-model="form.content_brief[ind].value">
              <a-radio value="正常">正常</a-radio>
              <a-radio value="更換">更換</a-radio>
              <a-radio value="建議更換">建議更換</a-radio>
            </a-radio-group>
          </div>
        </a-form-model-item>

        <a-form-model-item label="備註" prop="remark">
          <a-input v-model="form.remark" type="textarea"/>
        </a-form-model-item>
        <a-form-model-item label="附件" prop="attachment">

          <UploadList fieldName="attachment" @changeImages="changeImages"/>

        </a-form-model-item>
        <a-form-model-item>
          <a-button type="primary" @click="onSubmit">
            添加
          </a-button>
        </a-form-model-item>
      </a-form-model>

    </a-card>
  </div>
</template>

<script>
import UploadList from '#/components/UploadList'
import moment from 'moment'
import Search from "#/components/RemoteSearch";

const rules = {
  company_name: [{required: true, message: '請輸入公司名稱', trigger: 'change'}],
  report_date: [
    {
      required: true, message: '日期不能為空', trigger: 'blur'
    },
  ],
  car_number: [{required: true, message: '請輸入車牌', trigger: 'change'}],
  car_type: [{required: true, message: '請輸入車型', trigger: 'change'}],
  car_brand: [{required: true, message: '請輸入汽車品牌', trigger: 'change'}],
  mileage: [{required: true, message: '請輸入行車公里數', trigger: 'change'}],
  total_cost: [{required: true, message: '請輸入費用合計', trigger: 'change'}],
  content_brief: [{required: true, message: '請輸入內容簡報', trigger: 'blur'}],
}
const formItemLayout = {
  labelCol: {
    xs: {span: 24},
    sm: {span: 4},
  },
  wrapperCol: {
    xs: {span: 24},
    sm: {span: 20},
  },
}
const formItemLayoutWithOutLabel = {
  wrapperCol: {
    xs: {span: 24, offset: 0},
    sm: {span: 20, offset: 4},
  }
}
export default {
  components: {UploadList, Search},
  data() {
    return {
      carreportItem: [],
      formItemLayout,
      formItemLayoutWithOutLabel,
      rules,
      moment,
      url: 'admin/carinfo/searchCarInfo',
      form: {
        company_name: '',
        car_number: '',
        car_type: '',
        car_brand: '',
        repair_project: [{
          value: ''
        }],
        content_brief: [],
        attachment: [],
        report_date: moment().format('YYYY-MM-DD'),
      }
    }
  },
  created() {
    this.getCarReportItem()
  }
  ,
  methods: {
    async getCarReportItem() {
      let res = await this.axios.get('admin/caritem/index')
      this.carreportItem = res.map((item) => {
        return {
          name: item.name,
          title: item.title,
          value: item.value ? item.value : ''
        }
      })
      this.form.content_brief = this.carreportItem
    },
    async onSubmit() {
      this.$refs.ruleForm.validate(async valid => {
        if (valid) {
          console.log(this.form.content_brief.some(item => item.value == ''));
          if (this.form.content_brief.some(item => item.value == '')) {
            return this.$message.error({content: '內容簡報不完整'})
          }
          await this.axios.post('admin/carreport', this.form).then(_ => {
            this.$router.push('/admin/car/index')
          })
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    resetForm() {
      this.$refs.ruleForm.resetFields();
    },
    changeValue(data) {
      console.log('被點擊了')
      const {value} = data
      console.log(value)
      this.form.company_name = value.company_name
      this.form.car_number = value.car_number
      this.form.car_type = value.car_type
      this.form.car_brand = value.car_brand
      // console.log(data)
    },
    removeItem(item) {
      console.log(item)
      this.form.repair_project.splice(this.form.repair_project.findIndex(i => i.value === item.value), 1)
    },
    addItem() {
      this.form.repair_project.push({
        value: ''
      })
      console.log(this.form.repair_project)
    },
    radioChange(e) {
      console.log(e.target.value)
    },
    checkItem() {
      console.log('checkItem')
    },
    changeImages(images) {
      this.form.attachment = images
    },
  }
}
</script>

<style scoped lang="scss">
.dynamic-delete-button {
  cursor: pointer;
  position: relative;
  top: 4px;
  font-size: 24px;
  color: #999;
  transition: all 0.3s;
}

.dynamic-delete-button:hover {
  color: #777;
}

.dynamic-delete-button[disabled] {
  cursor: not-allowed;
  opacity: 0.5;
}

.list {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
  border: 1px solid #e8e8e8;

  /* 小尺寸時上下排列 */
  @media (max-width: 576px) {
    & > span {
      display: block;
    }

    & > list_group {
      display: block;
      padding-left: 10px;
    }

    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 10px;
  }
}
</style>