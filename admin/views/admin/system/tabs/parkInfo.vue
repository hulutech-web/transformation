<template>
  <div>
    <!--停车场相关配置-->
    <a-row :gutter="[16, 16]">
      <a-col :span="12">
        <a-card title="停車場配置">
          <template #extra>
            <a href="/files/parktemplate.xlsx">模板下載</a>
            <a-button-group>
              <ImportFile :action="parkUrl"/>
            </a-button-group>
          </template>
          <a-form-model ref="ruleParkForm" :model="parkForm" required :rules="parkRules">
            <a-form-model-item label="停車場名稱" prop="name">
              <a-input v-model="parkForm.name" placeholder="請填寫停車場名稱"></a-input>
            </a-form-model-item>
            <a-form-model-item label="停車場地址" prop="address">
              <a-input v-model="parkForm.address" placeholder="請填寫停車場地址"></a-input>
            </a-form-model-item>
            <a-form-model-item label="停車場聯繫電話">
              <a-input v-model="parkForm.mobile" placeholder="請填寫停車場聯繫電話"></a-input>
            </a-form-model-item>
            <a-form-model-item label="停車場負責人">
              <a-input v-model="parkForm.manager" placeholder="請填寫停車場負責人"></a-input>
            </a-form-model-item>
            <a-form-model-item>
              <a-button type="primary" @click="submitPark">提交</a-button>
            </a-form-model-item>
          </a-form-model>
          <a-table size="small" :pagination="false" :data-source="parkData.data" :columns="parkColumns" rowKey="id">
            <template slot="action" slot-scope="text,record">
              <a-button type="danger" size="small" @click="delPark(record)">刪除</a-button>
            </template>
          </a-table>
          <a-pagination style="margin-top:12px;" size="small" v-if="parkData.total > parkData.per_page"
                        :defaultCurrent='1'
                        :total="parkData.total" :pageSize="parkData.per_page" @change="getAllPark">
          </a-pagination>
        </a-card>
      </a-col>
      <a-col :span="12">
        <a-card title="车位配置">
          <template #extra>
            <a href="/files/stalltemplate.xlsx">模板下載</a>
            <a-button-group>
              <ImportFile :action="stallUrl"/>
              <a-button type="primary" @click="addStallForm">
                <a-icon type="plus"/>
                添加
              </a-button>
              <a-button type="danger" @click="delStallForm" :disabled="stallForm.arrForm.length<2">
                刪除
                <a-icon type="minus"/>
              </a-button>
            </a-button-group>
          </template>
          <a-row :gutter="[16,16]">

            <div v-for="(arrForm,index) in stallForm.arrForm" :key="index">
              <a-col :span="6">
                <a-form-model ref="rulestallForm" :model="arrForm" required :rules="stallRules" layout="inline">

                  <a-form-model-item label="停車場" prop="park_id">
                    <Search :value="arrForm.keywords" :searchForm="arrForm" @changeValue="changeValue"/>
                  </a-form-model-item>
                  <a-form-model-item label="車位編號" prop="number">
                    <a-input v-model="arrForm.number" placeholder="请输入品牌"></a-input>
                  </a-form-model-item>
                  <a-form-model-item label="車位位置" prop="location">
                    <a-input v-model="arrForm.location" placeholder="请输入車位位置"></a-input>
                  </a-form-model-item>
                </a-form-model>

              </a-col>

            </div>
          </a-row>

          <a-form-model-item>
            <a-button type="primary" @click="submitStall">提交</a-button>
          </a-form-model-item>
          <a-table size="small" :pagination="false" :data-source="stallData.data" :columns="stallColumns" rowKey="id">
            <template slot="action" slot-scope="text,record">
              <a-button type="danger" size="small" @click="delStall(record)">刪除</a-button>
            </template>
          </a-table>
          <a-pagination style="margin-top:12px;" size="small" v-if="stallData.total > stallData.per_page"
                        :defaultCurrent='1'
                        :total="stallData.total" :pageSize="stallData.per_page" @change="getAllStall">
          </a-pagination>
        </a-card>
      </a-col>
    </a-row>
  </div>
</template>

<script>
import Search from '#/components/RemoteSearch'
import ImportFile from '#/components/ImportFile'

const parkColumns = [
  {id: 'id', dataIndex: 'id', title: 'id'},
  {id: 'name', dataIndex: 'name', title: '名称'},
  {id: 'address', dataIndex: 'address', title: '地址'},
  {id: 'phone', dataIndex: 'phone', title: '电话'},
  {id: 'manager', dataIndex: 'manager', title: '负责人'},
  {id: 'action', dataIndex: 'action', title: '操作', scopedSlots: {customRender: 'action'},},
]
const stallColumns = [
  {id: 'id', dataIndex: 'id', title: 'id'},
  {id: 'park_name', dataIndex: 'park_name', title: '停車場'},
  {id: 'number', dataIndex: 'number', title: '車位編號'},
  {id: 'location', dataIndex: 'location', title: '車位位置'},
  {id: 'action', dataIndex: 'action', title: '操作', scopedSlots: {customRender: 'action'},},
]
const parkRules = {
  name: [
    {required: true, message: '請填寫停車場名稱', trigger: 'blur'},
  ],
  address: [{required: true, message: '請填寫停車場地址', trigger: 'blur'}],
}
const stallRules = {
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
      parkKeyword: '',
      stallKeyword: '',
      parkColumns,
      stallColumns,
      parkData: [],
      //stall上傳地址
      stallUrl: `http://${window.location.hostname}/api/import/stall`,
      parkUrl: `http://${window.location.hostname}/api/import/park`,
      parkRules,
      stallRules,
      stallData: [],
      parkForm: {},
      stallForm: {
        arrForm: [
          {
            park_id: '',
            number: '',
            location: '',
            keywords: ''
          }
        ]
      },
    }
  },
  created() {
    this.getAllPark();
    this.getAllStall();
  },
  methods: {
    submitPark() {
      this.$refs.ruleParkForm.validate(async valid => {
        if (valid) {
          await this.axios.post('admin/park', this.parkForm).then(_ => {
            this.getAllPark()
            this.$refs.ruleParkForm.resetFields();
          })
        } else {
          console.log('error submit!!');
          return false;
        }
      });

    },
    async getAllPark(page = 1) {
      this.parkData = await this.axios.get(`admin/park?page=${page}`)
    },
    async getAllStall(page = 1) {
      this.stallData = await this.axios.get(`admin/stall?page=${page}`)
    },
    async delPark(record) {
      this.$confirm({
        title: '危險操作，將刪除關聯的停車場信息，車位信息，設備信息，充電樁信息，報表信息?',
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'error',
        onOk: async () => {
          await this.axios.delete(`admin/park/${record.id}`).then(_ => {
            this.getAllPark()
            this.getAllStall()
          })
        }
      })
    },
    async delStall(record) {
      await this.axios.delete(`admin/stall/${record.id}`).then(_ => {
        this.getAllStall()
      })
    },
    addStallForm() {
      let length = this.stallForm.arrForm.length
      if (length >= 4) {
        return this.$message.error('抱歉！最多只能批量添加4個車位')
      }
      this.stallForm.arrForm.push({
        park_id: '',
        number: '',
        location: '',
        keywords: ''
      })
    },
    delStallForm() {
      this.stallForm.arrForm.pop()
    },
    async submitStall() {
      //執行所有rulestallForm數組中驗證
      let isValidate = 1;
      this.$refs.rulestallForm.forEach((item, index) => {
        item.validate(async valid => {
          if (!valid) {
            isValidate = 0;
          }
        })
      })


      if (isValidate !== 1) {
        this.$message.error('驗證失敗')

      } else {
        this.$message.success('驗證通過')
        await this.axios.post(`admin/park/stall/batch`, this.stallForm).then(_ => {
          this.getAllStall()
          this.keywords = ''
          this.$refs.rulestallForm.forEach(item => {
            item.resetFields()
          })
        })
      }
    },
    searchPark() {

    },
    searchStall() {

    },
    changeValue(data) {
      // 只是為了顯示搜索框的值
      const {value, form} = data
      let index = this.stallForm.arrForm.findIndex(item => item === form)
      this.stallForm.arrForm[index].keywords = value.name
      this.stallForm.arrForm[index].park_id = value.id
    }
  }
}
</script>

<style scoped lang="scss">
</style>