<template>
  <div>
    <a-spin size="small" :spinning="spinning">
      <a-card title="楼盘列表">
        <a slot="extra" href="#">
          <a-input-search placeholder="请输入关键字：楼盘名、项目名" style="width:300px" v-model="keywords" enter-button
                          @search="onSearch"/>
        </a>
        <a-table :pagination="false" size="small" bordered :dataSource="dataSource.data" rowKey="id"
                 :columns="columns">
          <template slot="operation" slot-scope="text, record">
            <a href="javascript:; " @click="edit(record)">编辑</a>
            <a-popconfirm v-if="dataSource.length" title="确定删除吗?" @confirm="() => onDelete(record)">
              <a href="javascript:;" style="color:red;">删除</a>
            </a-popconfirm>
            <a href="javascript:; " @click="show(record)">详情</a>

          </template>
          <template slot="action" slot-scope="text, record">
            <a href="javascript:; " @click="setUnit(record)">设置</a>
          </template>
        </a-table>

        <a-pagination v-if="dataSource.total>dataSource.per_page" :defaultCurrent='1' :total="dataSource.total"
                      :pageSize="dataSource.per_page"
                      @change="loadData">
        </a-pagination>
      </a-card>
    </a-spin>
  </div>
</template>

<script>
const columns = [
  {
    title: 'ID',
    dataIndex: 'id',
    key: 'id',
  },
  {
    title: '楼盘名称',
    dataIndex: 'name',
    key: 'name',
  },
  {
    title: '项目名称',
    dataIndex: 'project_name',
    key: 'project_name',

  },
  {
    title: '物业公司',
    dataIndex: 'property_company_name',
    key: 'property_company_name',

  },
  {
    title: '业主委员会',
    dataIndex: 'owner_committee_name',
    key: 'owner_committee_name',

  },
  {
    title: '项目介绍人',
    dataIndex: 'project_introducer',
    key: 'project_introducer',
  },
  {
    title: '建筑面积',
    dataIndex: 'building_area',
    key: 'building_area',

  }, {
    title: '主体单位',
    dataIndex: 'project_unit_name',
    key: 'project_unit_name',

  },
  {
    title: '修建时间',
    dataIndex: 'build_time',
    key: 'build_time',

  },
  {
    title: '承建商',
    dataIndex: 'project_builder_name',
    key: 'project_builder_name',

  },
  {
    title: '操作',
    dataIndex: 'operation',
    key: 'operation',
    scopedSlots: {customRender: 'operation'},
  },
  {
    title: '单元设置',
    dataIndex: 'action',
    key: 'action',
    scopedSlots: {customRender: 'action'},
  },
]

export default {
  data() {
    return {
      dataSource: [],
      user: JSON.parse(localStorage.getItem('user')),
      columns: columns,
      keywords: '',
      spinning: false
    }
  },
  created() {
    this.loadData()
  },
  methods: {
    async loadData(page = 1) {
      this.dataSource = await this.axios.get(`admin/build?page=${page}`)
    },
    onSearch() {
      this.spinning = true
      this.axios.post('admin/build/search', {keywords: this.keywords}).then(_ => {
        this.spinning = false
        this.dataSource = _
      })
    },
    async onDelete(record) {
      await this.axios.delete(`admin/build/${record.id}`)
      this.dataSource.splice(this.dataSource.indexOf(record), 1)
      this.loadData()
    },
    edit(record) {
      this.$router.push({
        path: `/admin/build/${record.id}/edit`,
      })
    },
    setUnit(record) {
      this.$router.push({name: 'admin.build.unit', params: {id: record.id}})
    },
    show(record) {
      this.$router.push({name: 'admin.build.show', params: {id: record.id}})
    }
  }


}
</script>

<style scoped>

</style>
