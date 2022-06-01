<template>
  <div>
    <a-card title="用户管理">
      <template #extra>
        <div style="display: flex;">
          <a-input-search enter-button placeholder="请输入姓名" @search="search"
                          v-model="keyword"></a-input-search>
          <a-button type="primary" @click="addUser" style="margin-left:5px;">
            <a-icon type="plus"></a-icon>
            添加
          </a-button>
        </div>

      </template>
      <div ref="content">
        <a-table :data-source="users.data" :columns="columns" rowKey="id" bordered :pagination="false">
          <template slot="action" slot-scope="text,record">
            <a-button-group>
              <a-button size="small" type="info" @click="handleEdit(record)">
                <a-icon type="form"/>
                编辑
              </a-button>
              <a-button size="small" ghost type="danger" @click="handleDelete(record)">
                <a-icon type="delete"/>
                删除
              </a-button>
              <a-button size="small" ghost type="primary" @click="handle(record)">
                <a-icon type="safety"/>
                角色
              </a-button>

            </a-button-group>
          </template>
        </a-table>
        <a-pagination v-if="users.total>users.per_page" :defaultCurrent='1' :total="users.total"
                      :pageSize="users.per_page"
                      @change="getUsers">
        </a-pagination>
      </div>
    </a-card>

    <!--        弹出-->

    <a-drawer
        title="管理用户"
        :width="720"
        :visible="visible"
        :body-style="{ paddingBottom: '80px' }"
        @close="onClose"
    >

      <a-form :form="formState" layout="vertical" hide-required-mark>
        <a-row :gutter="16">
          <a-col :span="8">
            <a-form-item label="用户名">
              <a-input
                  v-decorator="[
                  'name',
                  {
                    rules: [{ required: true, message: '用户名' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入用户名"
              />
            </a-form-item>

          </a-col>
          <a-col :span="8">
            <a-form-item label="手机号">
              <a-input
                  v-decorator="[
                  'mobile',
                  {
                    rules: [{ required: true, message: '手机号' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入手机号"
              />
            </a-form-item>
          </a-col>


          <a-col :span="8">
            <a-form-item label="密码">
              <a-input-password
                  v-decorator="[
                  'password',
                  {
                    rules: [{ required: true, message: '密码' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入密码"
              />
            </a-form-item>
          </a-col>


          <a-col :span="8">
            <a-form-item label="确认密码">
              <a-input-password
                  v-decorator="[
                  'password_confirmation',
                  {
                    rules: [{ required: true, message: '确认密码' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入确认密码"
              />
            </a-form-item>
          </a-col>
          <a-col :span="8">
            <a-form-item label="邮箱">
              <a-input
                  v-decorator="[
                  'email',
                  {
                    rules: [{ required: true, message: '邮箱' }],
                  },
                ]"
                  style="width: 100%"
                  placeholder="请输入邮箱"
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
        <a-button type="primary" @click="handleSubmit">
          提交
        </a-button>
      </div>
    </a-drawer>

    <!--        弹出end-->
  </div>

</template>

<script>
const rules = {
  name: [{
    validator: (rule, value, callback) => {
      if (value == '' || value == undefined) {
        callback(new Error('请选择楼盘'));
      }
      callback();

    }, trigger: 'change'
  }],
  mobile: [{
    validator: (rule, value, callback) => {
      if (value == '' || value == undefined) {
        callback(new Error('请输入门牌号'));
      }
      //验证手机号
      if (!/^1[3456789]\d{9}$/.test(value)) {
        callback(new Error('手机号码不合法'));
      }
      callback();

    }, trigger: 'change'
  }],
  password: [{
    validator: (rule, value, callback) => {
      if (value == '' || value == undefined) {
        callback(new Error('请输入密码'));
      }
      callback();

    }, trigger: 'change'
  }],
  password_confirm: [{
    validator: (rule, value, callback) => {
      if (value == '' || value == undefined) {
        callback(new Error('请输入户主'));
      }
      callback();
    }, trigger: 'change'
  }],
  email: [{
    validator: (rule, value, callback) => {
      if (value == '' || value == undefined) {
        callback(new Error('请输入邮箱'));
      }
      //验证身份证
      if (!/^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/.test(value)) {
        callback(new Error('邮箱不合法'));
      }
      callback();
    }, trigger: 'change'
  }],
}
const columns = [
  {
    title: 'ID',
    dataIndex: 'id',
    key: 'id',
    width: 80,
    align: 'center'
  },
  {
    title: '用户名',
    dataIndex: 'name',

    key: 'name',
    width: 100,
    align: 'center'
  },
  {
    title: '手机号',
    dataIndex: 'mobile',
    key: 'mobile',
    width: 100,
    align: 'center'
  },
  {
    title: '邮箱',
    dataIndex: 'email',

    key: 'email',
    width: 200,
    align: 'center'
  },
  {
    title: '操作',
    key: 'action',
    dataIndex: 'action',
    width: 200,
    align: 'center',
    scopedSlots: {customRender: 'action'}
  },
]
export default {
  data() {
    return {
      users: [],
      columns,
      user: JSON.parse(localStorage.getItem('user')),
      visible: false,
      keyword: ''
    }
  },
  beforeCreate() {
    this.formState = this.$form.createForm(this);
  },
  created() {
    this.getUsers();
  },
  methods: {
    async getUsers(page = 1) {
      this.users = await this.axios.get(`user?page=${page}`)
    },
    onClose() {
      this.visible = false
      this.formState.resetFields();
    },
    addUser() {
      this.visible = true
    },
    handleSubmit() {
//验证
      this.formState.validateFields(async (err, values) => {
        if (!err) {
          console.log(values);
          await this.axios.post('user', values)
          await this.getUsers()
          this.visible = false
        }
      });
    },
    async search() {
      this.users = await this.axios.post('user/search', {keyword: this.keyword})
    },
    handle(record) {
      this.$router.push({name: 'admin.user.role', params: {id: record.id}})
    },
    async handleDelete(record) {
      await this.axios.delete(`user/${record.id}`).then(_ => {
        this.users.splice(this.users.indexOf(record), 1);
      })
    },
    handleEdit(record) {
      this.$router.push({name: 'admin.user.edit', params: {id: record.id}})
    }
  }
}
</script>

<style scoped>
</style>
