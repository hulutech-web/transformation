<template>
  <div>
    <a-row :gutter="[16,16]">
      <a-col :span="12">
        <a-card title="充电桩字段配置">
          <a-form-model>
            <a-form-item label="初始化字段">
              <a-button type="primary" @click="initField">初始化</a-button>
            </a-form-item>
            <a-form-item label="清空字段">
              <a-button type="danger" @click="resetField">清空字段</a-button>
            </a-form-item>
          </a-form-model>

        </a-card>
      </a-col>
      <a-col :span="12">
        <a-card title="报告选项">
          <a-table :data-source="allFields" rowKey="id" :columns="columns">
            <template slot="options" slot-scope="text,record">
              <div>
                  <span v-for="(r,index) in record.field_options" :key="index">
                    【{{ r['field_id'] }}-{{ r['field_name'] }}】
                  </span>
              </div>
            </template>
          </a-table>
        </a-card>
      </a-col>
    </a-row>
  </div>
</template>

<script>

const columns = [
  {id: 'id', dataIndex: 'id', title: 'id'},
  {id: 'field_name', dataIndex: 'field_name', title: '字段名'},
  {id: 'field_options', dataIndex: 'field_options', title: '字段选项', scopedSlots: {customRender: 'options'}},
]
export default {
  data() {
    return {
      columns,
      allFields: []
    }
  },
  created() {
    this.getAllFields()
  },
  methods: {
    async initField() {
      await this.axios.post('admin/chargingreportfield/init')
    },
    async resetField() {
      await this.axios.post('admin/chargingreportfield/reset')
    },
    async getAllFields() {
      this.allFields = await this.axios.post('admin/chargingreportfield/getAllFields')
    }

  }
}
</script>

<style scoped>

</style>