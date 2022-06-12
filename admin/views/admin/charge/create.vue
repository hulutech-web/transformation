<template>
  <div>
    <a-card title="添加充電樁報告">
      <template #extra>
        <a href="/files/stalltemplate.xlsx">模板下載</a>
        <a-button-group>
          <ImportFile :action="ChargingReportUrl"/>
          <a-button type="primary" @click="addChargingReportStall" :disabled="stalls.length>=50">
            <a-icon type="plus"/>
            添加
          </a-button>
          <a-button type="danger" @click="delChargingReportStall" :disabled="stalls.length<2">
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
                  @changeValue="changeValue" :disable="disabledSelectPark"/>

        </a-form-model-item>
        <a-row :gutter="[16,16]">

          <a-col :span="6" v-for="(stallItem,index) in stalls" :key="index">
            <div style="border: #8c939d 1px dotted;padding:10px;" @click="locationPoint(index)">
              <a-tag color="#f50">
                #{{ index + 1 }}
              </a-tag>
              <a-form-model-item label="停車場車位號" prop="stalls">
                <a-select @change="handleChange">
                  <a-select-option v-for="(stall) in stallOptions" :key="stall.id"
                                   :disabled="ChargingPiles.some(item=>item.id==stall.id)">
                    {{ stall.number }}
                  </a-select-option>
                </a-select>
              </a-form-model-item>

              <a-form-model-item label="设备信息" prop="charging_pile_id">
                <a-descriptions size="small" layout="vertical" bordered :column="4">
                  <a-descriptions-item :label="name" v-for="(value, name) in  ChargingPiles[index]"
                                       :key="name">
                    <span style="font-size: .6rem;">{{ value }}</span>
                  </a-descriptions-item>
                </a-descriptions>

              </a-form-model-item>
              <a-collapse>
                <a-collapse-panel key="1" header="報告詳情">
                  <a-form-model-item label="報告內容" prop="result">
                    <div v-for="(item, ind) in chargingFields" :key="ind" class="list">
                      <!--                      一級描述-->
                      <span style="font-weight: bold">{{ item.field_id }}:{{ item.field_name }}</span>
                      <!--選項-->
                      <div v-for="(sub,idx) in item.field_options" :key="idx">
                        <span>{{ sub.field_id }}:{{ sub.field_name }}</span>
                        <a-radio-group class="list_group"
                                       v-model="chargingReportForm.results[index].resultData[ind].field_options[idx].value"
                                       :default-value="sub.value">
                          <a-radio value="P">P</a-radio>
                          <a-radio value="F">F</a-radio>
                          <a-radio value="N">N</a-radio>
                        </a-radio-group>
                      </div>

                    </div>
                  </a-form-model-item>
                </a-collapse-panel>
              </a-collapse>
            </div>

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
import lodash from 'lodash'
// lodash.cloneDeep(objects)
import moment from 'moment'
import results from './resultData'

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
      disabledSelectPark: false,
      locationId: 0,//從0開始
      chargingReportForm: {
        report_date: moment().format('YYYY-MM-DD'),//必要
        stall_ids: [],//必要取stall_ids
        park_id: '',//必要
        remark: '',//必要
        user_id: JSON.parse(localStorage.getItem('user'))['id'],//必要
        park_name: '',
        results: [{resultData: results, device_id: null}],
      },
      stalls: [
        {
          id: '',
          number: '',
          location: '',
        }
      ],
      ChargingPiles: [
        {
          id: '',
          device_id: '',
          brand: '',
          model: '',
        }
      ],
      results: [],
      ChargingReportUrl: `http://${window.location.hostname}/api/import/park`,
      parkUrl: `http://${window.location.hostname}/api/import/park`,
      stallOptions: [],
    }
  },
  watch: {
    'chargingReportForm.park_id'(n) {
      this.getStallByParkId(n)
    },
    'helpStallId'(n) {
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
    getChargingPileByStallId(stall_id) {
      return this.axios.get(`admin/stall/${stall_id}/getchargingpilebystall`)
    },
    async handleChange(data) {
      //需要觸發查找事件，獲取充電樁信息
      //得到的是94，為該設備ID
      console.log(data)
      // return
      let stall_id = data
      let res = await this.getChargingPileByStallId(stall_id)
      Object.assign(this.ChargingPiles[this.locationId], {
        id: res.id,//充電樁ID
        device_id: res.device_id,
        brand: res.brand,
        model: res.model,
      })
      //把充電樁ID放入results
      this.chargingReportForm.results[this.locationId].device_id = res.id
      //✨提交的數據
      this.chargingReportForm.stall_ids.push({
        id: stall_id
      })
    },
    async getStallByParkId(park_id) {
      this.stallOptions = await this.axios.post(`admin/park/${park_id}/getstallbypark`)
    },
    changeValue(data) {
      // 停車場選擇事件，只是為了顯示搜索框的值
      const {value, form} = data
      this.disabledSelectPark = true
      this.chargingReportForm.park_id = value.id
      this.chargingReportForm.park_name = value.name
    },
    addChargingReportStall() {
      this.stalls.push({
        number: '',
        location: '',
      })
      this.ChargingPiles.push({
        id: '',
        device_id: '',
        brand: '',
        model: '',
      })
      let data = lodash.cloneDeep(this.chargingReportForm.results[0])
      this.chargingReportForm.results.push(data)
    },
    delChargingReportStall() {
      this.stalls.pop()
      this.chargingReportForm.stall_ids.pop()
    },
    async onSubmit() {
      await this.axios.post('admin/chargingreport/create', this.chargingReportForm).then(_ => {
        this.$router.push({path: '/admin/charge/index'})
      })
    },
    //輔助函數，幫助定位當前選擇的是第幾個
    locationPoint(index) {
      this.locationId = index
    }
  }
}
</script>

<style scoped>

</style>