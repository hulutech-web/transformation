<template>
  <div>
    <a-card title="楼盘单元|栋|幢">
      <template #extra>
        <a-button type="primary" @click="addFloor">
          <a-icon type="plus"/>
          新增单元|栋|幢
        </a-button>
      </template>
      <a-table rowKey="id" :pagination="false" :dataSource="dataSource" bordered :columns="columns" >
        <template slot="operation" slot-scope="text, record">
          <a href="javascript:; " @click="edit(record)">编辑</a>
          <a-popconfirm v-if="dataSource.length" title="确定删除吗?" @confirm="() => onDelete(record)">
            <a href="javascript:;" style="color:red;">删除</a>
          </a-popconfirm>
        </template>
      </a-table>
      <a-pagination v-if="dataSource.total>dataSource.per_page" :defaultCurrent='1' :total="dataSource.total"
                    :pageSize="dataSource.per_page"
                    @change="getData">
      </a-pagination>
    </a-card>
    <div>


      <a-drawer
          title="管理单元|栋|幢"
          :width="720"
          :visible="visible"
          :body-style="{ paddingBottom: '80px' }"
          @close="onClose"
      >

        <a-form :form="form" layout="vertical" hide-required-mark>
          <a-row :gutter="16">
            <a-col :span="12">
              <a-form-item label="单元名称">
                <a-input
                    v-decorator="[
                  'unit_name',
                  {
                    rules: [{ required: true, message: '单元名称' }],
                  },
                ]"
                    placeholder="请输入单元名称"
                />
              </a-form-item>
            </a-col>
            <a-col :span="12">
              <a-form-item label="单元编号">
                <a-input-number
                    :min="0"
                    v-decorator="[
                  'unit_number',
                  {
                    rules: [{ required: true, message: '单元编号' }],
                  },
                ]"
                    style="width: 100%"
                    placeholder="请输入单元编号"
                />
              </a-form-item>
            </a-col>
          </a-row>
          <a-row :gutter="16">
            <a-col :span="12">
              <a-form-item label="层数">
                <a-input-number
                    :min="0"
                    v-decorator="[
                  'floor_number',
                  {
                    rules: [{ required: true, message: '楼层数' }],
                  },
                ]"
                    style="width: 100%"
                    placeholder="请输入楼层数"
                />
              </a-form-item>
            </a-col>
            <a-col :span="12">
              <a-form-item label="总户数">
                <a-input-number
                    :min="0"
                    v-decorator="[
                  'total_households',
                  {
                    rules: [{ required: true, message: '总户数' }],
                  },
                ]"
                    placeholder="请输入总户数"
                    style="width: 100%"
                />
              </a-form-item>
            </a-col>
          </a-row>
        </a-form>
        <div
            :style="{
          position: 'absolute',
          right: 0,
          bottom: 0,
          width: '100%',
          borderTop: '1px solid #e9e9e9',
          padding: '10px 16px',
          background: '#fff',
          textAlign: 'right',
          zIndex: 1,
        }"
        >
          <a-button type="primary" @click="onClose">
            取消
          </a-button>
          <a-button type="primary" @click="onSubmit">
            提交
          </a-button>
        </div>
      </a-drawer>
    </div>


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
    title: '单元名称',
    dataIndex: 'unit_name',
    key: 'unit_name',
  },
  {
    title: '楼层数',
    dataIndex: 'floor_number',
    key: 'floor_number',

  },
  {
    title: '总户数',
    dataIndex: 'total_households',
    key: 'total_households',

  },

  {
    title: '操作',
    dataIndex: 'operation',
    key: 'operation',
    scopedSlots: {customRender: 'operation'},
  },
]
export default {
  path: '/admin/build/:id/unit',
  data() {
    return {
      id: this.$route.params.id,
      uid: null,
      dataSource: [],
      columns,
      visible: false,
      method: 'post',
    }
  },
  beforeCreate() {
    this.form = this.$form.createForm(this);
  },
  created() {
    this.getData();
  },
  methods: {
    async getData(page = 1) {
      await this.axios.get(`admin/build/${this.id}/unit?page=${page}`).then(_ => {
        this.dataSource = _.data
      })
    },
    edit(record) {
      this.visible = true;
      this.uid = record.id;
      this.$nextTick(() => {
        this.form.setFieldsValue({
          unit_name: record.unit_name,
          unit_number: record.unit_number,
          floor_number: record.floor_number,
          total_households: record.total_households,
        });
        this.method = 'put';
      })
    },
    async onDelete(record) {
      await this.axios.delete(`admin/build/${this.id}/unit/${record.id}`)
      this.dataSource.splice(this.dataSource.indexOf(record), 1)
      await this.getData()
    },
    addFloor() {
      this.visible = true;
    },
    onClose() {
      this.visible = false;
      //清空form
      this.form.resetFields();
    },
    onSubmit() {
      this.form.validateFields((err, values) => {
        if (!err) {
          values = Object.assign(values, {build_id: this.id});
          console.log(values);
          let url = this.method === 'post' ? `admin/build/${this.id}/unit` : `admin/build/${this.id}/unit/${this.uid}`;
          this.axios[this.method](url, values).then(res => {
            this.visible = false;
            this.form = this.$form.createForm(this);
            this.getData();
          });
        }
      });
    },
  }
}
</script>

<style scoped>

</style>
