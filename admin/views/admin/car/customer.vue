<template>
  <div>
    <a-card title="客戶列表" size="small">
      <a-table :columns="columns" size="small" bordered :data-source="costomers.data" :pagination="false" rowKey="id">
        <template slot="action" slot-scope="text,record">
          <a-button-group>
            <a-button size="small" type="primary" @click="handleEdit(record)">
              <a-icon type="form"/>
              编辑
            </a-button>
            <a-button size="small" ghost type="danger" @click="handleDelete(record)">
              <a-icon type="delete"/>
              删除
            </a-button>
          </a-button-group>
        </template>

      </a-table>
      <a-pagination v-if="costomers.total>costomers.per_page" :defaultCurrent='1' :total="costomers.total"
                    :pageSize="costomers.per_page"
                    @change="getCarInfo">
      </a-pagination>
    </a-card>
  </div>
</template>

<script>
const columns = [
  {
    id: 'id',
    title: 'ID',
    dataIndex: 'id',
    key: 'id',
  },
  {
    id: 'company_name',
    title: '公司名稱',
    dataIndex: 'company_name',
    key: 'company_name',
  },
  {
    id: 'car_number',
    title: '車牌',
    dataIndex: 'car_number',
    key: 'car_number',
  },
  {
    id: 'car_brand',
    title: '品牌',
    dataIndex: 'car_brand',
    key: 'car_brand',
  },
  {
    id: 'car_type',
    title: '車型',
    dataIndex: 'car_type',
    key: 'car_type',
  },
  {
    id: "action",
    title: '操作',
    dataIndex: 'action',
    key: 'action',
    scopedSlots: {customRender: 'action'},
  }
]
export default {
  path: "/admin/car/customer",
  data() {
    return {
      columns: columns,
      costomers: []
    }
  },
  created() {
    this.costomers = this.getCarInfo()
  },
  methods: {
    async getCarInfo() {
      this.costomers = await this.axios.get('admin/carinfo')
    },
    handleEdit(record) {
      this.$router.push({path: `/admin/car/${record.id}/infoEdit`})
    },
    handleDelete(record) {
      this.$confirm({
        title: 'Confirm',
        content: '确定删除该条记录吗？',
        okText: '确认',
        cancelText: '取消',
        onOk: async () => {
          await this.axios.delete(`admin/carinfo/${record.id}`)
          this.getCarInfo()
        }
      });

    }
  }
}
</script>

<style scoped>

</style>