<template>
  <div class="main">
    <div>
      <p style="text-align: center;font-size: 1.5rem;">楼盘管理系统</p>
      <a-form>
        <a-form-item>
          <a-input size="large" v-model="form.mobile" placeholder="手机号">
            <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)"/>
          </a-input>
        </a-form-item>
        <a-form-item>
          <a-input size="large" v-model="form.password" type="password" placeholder="密码">
            <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)"/>
          </a-input>
        </a-form-item>
        <a-form-item>
          <captcha v-model="form.captcha" ref="captcha"/>
        </a-form-item>
        <a-form-item>
          <a-button style="width:100%;text-align:center;font-size: 18px;" type="primary" @click="handleSubmit">
            登 录
          </a-button>
        </a-form-item>
      </a-form>
    </div>
  </div>

</template>

<script>
import img from '#/assets/images/logo.png';
import Captcha from '#/components/Captcha/Captcha.vue'

export default {
  components: {Captcha},
  data() {
    return {
      form: {},
      img: img
    };
  },
  methods: {
    handleSubmit(e) {
      e.preventDefault();
      this.axios.post('admin/user/login', this.form).then(res => {
        // 调用ref的get方法
        this.$refs.captcha.get();
        const {token} = res
        if (token) {
          localStorage.setItem('token', token)
          this.axios.post("admin/user/info").then(res => {
            localStorage.setItem('user', JSON.stringify(res))
            this.$router.push({path: '/admin/index'})
          })
        }
      })
    },
  },
};
</script>
<style scoped>
/*
水平垂直居中
*/
.main {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

</style>
