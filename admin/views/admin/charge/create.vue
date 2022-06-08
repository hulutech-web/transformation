<template>
  <div>
    <a-card title="添加充電樁報告">
      <template #extra>
        <a href="/files/stalltemplate.xlsx">模板下載</a>
        <a-button-group>
          <ImportFile :action="ChargingReportUrl"/>
          <a-button type="primary" @click="addChargingReportForm" :disabled="chargingReportForm.stalls.length>2">
            <a-icon type="plus"/>
            添加
          </a-button>
          <a-button type="danger" @click="delChargingReportForm" :disabled="chargingReportForm.stalls.length<2">
            刪除
            <a-icon type="minus"/>
          </a-button>
        </a-button-group>
      </template>


      <a-form-model ref="chargingReportForm" :model="chargingReportForm" required :rules="chargingReportRules">
        <a-form-model-item label="填報時間" prop="report_date">
          <a-date-picker :default-value="moment(new Date().toLocaleDateString(), 'YYYY-MM-DD')"
                         valueFormat="YYYY-MM-DD" v-model="chargingReportForm.report_date" type="date"
                         placeholder="請輸入日期"
                         style="width: 100%;"/>
        </a-form-model-item>
        <a-form-model-item label="停車場" prop="park_name">

          <Search :value="chargingReportForm.park_name" width="100%" :searchForm="chargingReportForm"
                  @changeValue="changeValue"/>

        </a-form-model-item>
        <a-row :gutter="[16,16]">
          <a-col :span="6" v-for="(stallItem,index) in chargingReportForm.stalls" :key="index">

            <a-form-model-item label="停車場車位號" prop="stalls">
              <a-select :value="stallValue" @change="handleChange">
                <a-select-option v-for="(stall,index) in stallOptions" :key="index">{{ stall.number }}</a-select-option>
              </a-select>
            </a-form-model-item>


            <a-form-model-item label="设备信息" prop="charging_pile_id">
              <a-card>
                <a-descriptions size="small">
                  <a-descriptions-item :label="name" v-for="(value, name) in  ChargingPile" :key="name">
                    {{ value }}
                  </a-descriptions-item>
                </a-descriptions>
              </a-card>

            </a-form-model-item>
            <a-collapse>
              <a-collapse-panel key="1" header="報告詳情">
                <a-form-model-item label="報告內容" prop="result">
                  <div v-for="(item, ind) in chargingFields" :key="ind" class="list">
                    <span style="padding-left:10px;">{{ item.field_id }}:{{ item.field_name }}</span>

                    <div v-for="(sub,index) in item.field_options" :key="index">
                      <span>{{ sub.field_id }}:{{ sub.field_name }}</span>
                      <a-radio-group class="list_group"
                                     v-if="chargingReportForm.result.length > 0"
                                     v-model="chargingReportForm.result[ind].field_options[index].value">
                        <a-radio value="P">P</a-radio>
                        <a-radio value="F">F</a-radio>
                        <a-radio value="N">N</a-radio>
                      </a-radio-group>
                    </div>

                  </div>
                </a-form-model-item>
              </a-collapse-panel>
            </a-collapse>


          </a-col>
        </a-row>
        <a-form-model-item label="備註" prop="charging_pile_id">
          <a-textarea placeholder="請填寫備註" :rows="4" v-model="chargingReportForm.remark"/>
        </a-form-model-item>
        <a-form-model-item>
          <a-button type="primary" @click="onSubmit">提交</a-button>
        </a-form-model-item>
      </a-form-model>

    </a-card>
  </div>
</template>

<script>
import Search from "#/components/RemoteSearch";
import ImportFile from "#/components/ImportFile";
// lodash.cloneDeep(objects)
import cloneDeep from "lodash/cloneDeep";
import moment from 'moment'

const chargingReportColumns = [
  {id: 'id', dataIndex: 'id', title: 'id'},
  {id: 'name', dataIndex: 'name', title: '名称'},
  {id: 'address', dataIndex: 'address', title: '地址'},
  {id: 'phone', dataIndex: 'phone', title: '电话'},
  {id: 'manager', dataIndex: 'manager', title: '负责人'},
  {id: 'action', dataIndex: 'action', title: '操作', scopedSlots: {customRender: 'action'},},
]
const chargingReportRules = {
  park_id: [
    {required: true, message: '請選擇停車場', trigger: 'blur'},
  ],
  number: [{required: true, message: '请输入品牌', trigger: 'blur'}],
  location: [{required: true, message: '请输入車位位置', trigger: 'blur'}],
}
export default {
  components: {Search, ImportFile},
  data() {
    return {
      moment,
      chargingReportColumns,
      chargingReportRules,
      chargingFields: [],
      stallValue: '',
      chargingReportForm:
          {
            report_date: moment(new Date().toLocaleDateString(), 'YYYY-MM-DD'),
            park_id: '',
            park_name: '',
            stalls: [
              {
                number: '',
                location: '',
              }
            ],
            charging_pile_id: '',
            charging_results: [],
            user_id: JSON.parse(localStorage.getItem('user'))['id'],
            remark: '',
            result: []
          },
      ChargingPile: {},
      ChargingReportUrl: `http://${window.location.hostname}/api/import/park`,
      parkUrl: `http://${window.location.hostname}/api/import/park`,
      parkKeyword: '',
      stallOptions: [],
    }
  },
  watch: {
    'chargingReportForm.park_id'(n) {
      this.getStallByParkId(n)
    },
    'chargingReportForm.stall_id'(n) {
      this.getChargingPileByStallId(n)
    },
  },
  created() {
    this.getAllChargingFields()
  },
  methods: {
    async getAllChargingFields() {
      this.chargingFields = await this.axios.post('admin/chargingreportfield/getAllFields')

    },
    async getChargingPileByStallId(stall_id) {
      this.ChargingPile = await this.axios.get(`admin/stall/${stall_id}/getchargingpilebystall`)
    },
    handleChange(index) {
      console.log(index)
      this.chargingReportForm.stalls[0].number = this.stallOptions[index].number
      this.chargingReportForm.stalls[0].location = this.stallOptions[index].location
    },
    async getStallByParkId(park_id) {
      this.stallOptions = await this.axios.post(`admin/park/${park_id}/getstallbypark`)
    },
    changeValue(data) {
      // 只是為了顯示搜索框的值
      console.log(data)
      const {value, form} = data
      this.chargingReportForm.park_id = value.id
      this.chargingReportForm.park_name = value.name
    },
    addChargingReportForm() {
      if (this.chargingReportArr.length >= 3) {
        this.$message.error('最多只能添加三个停车场')
        return
      }
      let form = cloneDeep(this.chargingReportArr[0])
      this.chargingReportArr.push(form)
    },
    delChargingReportForm() {
      this.chargingReportArr.pop()
    },
    onSubmit() {
      console.log()
      // console.log(this.chargingReportForm)
    }
  }
}
</script>

<style scoped>

</style>