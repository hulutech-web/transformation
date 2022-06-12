<template>
  <div>
    <a-card title="充電樁信息配置">
      <template #extra>
        <a href="/files/chargingpiletemplate.xlsx">模板下載</a>
        <a-button-group>
          <ImportFile :action="chargingpileUrl"/>
        </a-button-group>
      </template>
      <a-form-model ref="chargingPileForm" :model="chargingPileForm" required :rules="parkPileRules">
        <a-input v-model="chargingPileForm.park_id" hidden></a-input>
        <a-form-model-item label="停車場車位（搜索）" prop="park_name">
          <Search :value="chargingPileForm.park_name" width="100%" :searchForm="chargingPileForm"
                  @changeValue="changeValue"/>
        </a-form-model-item>
        <a-form-model-item label="車位號（選擇）" prop="stall_id">
          <a-input v-model="chargingPileForm.stall_id" hidden></a-input>
          <a-select :value="stallValue" @change="handleChange">
            <a-select-option v-for="(stall,index) in stallOptions" :key="index">{{ stall.number }}</a-select-option>
          </a-select>
        </a-form-model-item>
        <a-form-model-item label="停車場設備編號" prop="device_id">
          <a-input v-model="chargingPileForm.device_id" placeholder="請填寫停車場設備ID"></a-input>
        </a-form-model-item>
        <a-form-model-item label="停車場設備品牌" prop="brand">
          <a-input v-model="chargingPileForm.brand" placeholder="請填寫停車場設備品牌"></a-input>
        </a-form-model-item>
        <a-form-model-item label="停車場設備類型" prop="model">
          <a-input v-model="chargingPileForm.model" placeholder="請填寫停車場設備類型"></a-input>
        </a-form-model-item>
        <a-form-model-item>
          <a-button type="primary" @click="submitParkPile">提交</a-button>
        </a-form-model-item>
      </a-form-model>

    </a-card>
    <a-card title="充電樁列表">
      <a-table :pagination="false" size="small" bordered :data-source="chargingPiles.data"
               :columns="chargingPileColumns"
               rowKey="id">
        <template slot="action" slot-scope="text,record">
          <a-button type="danger" size="small" @click="delChargingPile(record)">刪除</a-button>
        </template>
      </a-table>
      <a-pagination style="margin-top:12px;" size="small" v-if="chargingPiles.total > chargingPiles.per_page"
                    :defaultCurrent='1'
                    :total="chargingPiles.total" :pageSize="chargingPiles.per_page" @change="getAllchargingPile">
      </a-pagination>
    </a-card>

  </div>
</template>

<script>
import ImportFile from '#/components/ImportFile'
import Search from '#/components/RemoteSearch'

const parkPileRules = {
  park_id: [
    {required: true, message: '请填写停车場車位', trigger: 'blur'}
  ],
  device_id: [
    {required: true, message: '請填寫設備ID', trigger: 'blur'},
  ],
  brand: [{required: true, message: '請填寫品牌', trigger: 'blur'}],
  model: [{required: true, message: '請填寫型號', trigger: 'blur'}],
};
const chargingPileColumns = [
  {id: 'id', dataIndex: 'id', title: 'id'},
  {id: 'device_id', dataIndex: 'device_id', title: '設備ID'},
  {id: 'brand', dataIndex: 'brand', title: '品牌'},
  {id: 'model', dataIndex: 'model', title: '型號'},
  {id: 'action', dataIndex: 'action', title: '操作', scopedSlots: {customRender: 'action'},},
]
export default {
  components: {ImportFile, Search},
  data() {
    return {
      chargingPileForm: {
        park_id: '',
        park_name: '',
        stall_id: '',
      },
      chargingPileColumns,
      chargingPiles: [],
      stallOptions: [],
      stallValue: '',
      parkPileRules,
      chargingpileUrl: `http://${window.location.hostname}/api/import/chargingpile`,
    }
  },
  created() {
    this.getAllchargingPile()
  },
  watch: {
    'chargingPileForm.park_id'(n) {
      this.getStallByParkId(n)
    }
  },
  methods: {
    submitParkPile() {
      this.$refs.chargingPileForm.validate(async (valid) => {
        if (valid) {
          await this.axios.post('admin/chargingpile/store', this.chargingPileForm).then(_=>{
          //  清空表单
            this.$refs['chargingPileForm'].resetFields();
          })
        }
      })
    },
    async getStallByParkId(park_id) {
      this.stallOptions = await this.axios.post(`admin/park/${park_id}/getstallbypark`)
    },
    changeValue(data) {
      this.chargingPileForm.park_id = data.value.id
      this.chargingPileForm.park_name = data.value.name
    },
    handleChange(data) {
      this.chargingPileForm.stall_id = this.stallOptions[data].id
      this.stallValue = this.stallOptions[data].number
    },
    async getAllchargingPile(page = 1) {
      this.chargingPiles = await this.axios.get(`admin/chargingpile?page=${page}`)
    },
    async delChargingPile(record) {
      this.axios.delete(`admin/chargingpile/${record.id}`).then(_ => {
        this.getAllchargingPile()
      })
    }
  }
}
</script>

<style scoped>

</style>