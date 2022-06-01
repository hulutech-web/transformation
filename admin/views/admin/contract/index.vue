<template>
  <div>
    <a-card title="合同列表">
      <template #extra>
        <a-input-search enter-button placeholder="请输入所有人" v-model="keyword" @search="onSearch"></a-input-search>
      </template>
      <a-table :dataSource="contracts.data" :columns="columns" bordered rowKey="id" :pagination="false">
        <template slot="operation" slot-scope="text, record">
          <a href="javascript:; " @click="edit(record)">编辑</a>
          <a href="javascript:; " @click="show(record)">预览</a>
          <a-popconfirm v-if="contracts.data.length" title="确定删除吗?" @confirm="() => onDelete(record)">
            <a href="javascript:;" style="color:red;">删除</a>
          </a-popconfirm>

        </template>
      </a-table>
      <a-pagination v-if="contracts.total>contracts.per_page" :defaultCurrent='1' :total="contracts.total"
                    :pageSize="contracts.per_page"
                    @change="getContracts">
      </a-pagination>
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
    title: '所有人',
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
      keyword: '',
      columns,
      contracts: [],
      user: JSON.parse(localStorage.getItem('user')),
    }
  },
  created() {
    this.getContracts()
  },
  methods: {
    async getContracts(page = 1) {
      this.contracts = await this.axios.post(`admin/user/${this.user.id}/contract/getUserContract?page=${page}`)
    },
    edit(record) {
        this.$router.push(`/admin/contract/${record.id}/edit`)
    },
    show(record) {
        this.$router.push(`/admin/contract/${record.id}/show`)
    },
    async onDelete(record) {
      await this.axios.delete(`admin/contract/${record.id}`)
      await this.getContracts()
    },
    async onSearch() {
      this.contracts = await this.axios.post(`admin/user/${this.user.id}/contract/getOwnerContract`, {keyword: this.keyword})
    },
    pay(record) {

    }
  }
}
</script>

<style></style>
