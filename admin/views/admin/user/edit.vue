<template>
  <div>
    <a-card title="编辑用户">
      <a-form-model :model="form" :label-col="labelCol" :wrapper-col="wrapperCol">
        <a-form-model-item label="姓名">
          <a-input type="text" v-model="form.name"></a-input>
        </a-form-model-item>
        <a-form-model-item label="邮箱">
          <a-input type="email" v-model="form.email"></a-input>
        </a-form-model-item>
        <a-form-model-item label="手机号">
          <a-input type="text" v-model="form.mobile"></a-input>
        </a-form-model-item>
        <a-form-model-item label="密码">
          <a-input type="password" v-model="form.password"></a-input>
        </a-form-model-item>
        <a-form-model-item label="确认密码">
          <a-input type="password" v-model="form.password_confirmation"></a-input>
        </a-form-model-item>
        <a-form-model-item :wrapper-col="{ span: 14, offset: 4 }">
          <a-button type="primary" @click="onSubmit">
            保存
          </a-button>
        </a-form-model-item>
      </a-form-model>
    </a-card>
  </div>
</template>

<script>
import UploadImage from "#/components/Upload/Index";

export default {
  components: {
    UploadImage
  },
  meta: {title: "编辑用户"},
  path: '/admin/user/:id/edit',
  data() {
    return {
      labelCol: {span: 4},
      wrapperCol: {span: 14},
      id: this.$route.params.id,
      form: {},
      user: JSON.parse(localStorage.getItem('user')),
    }
  },
  created() {
    this.getUser();
  },
  methods: {
    async getUser() {
      this.form = await this.axios.get(`user/${this.id}`)
    },
    async onSubmit() {
      await this.axios.put(`user/${this.id}`, this.form).then(_ => {
        this.$router.push({name: 'admin.user.index'})
      })
    },
  }
}
</script>

<style scoped>
</style>
