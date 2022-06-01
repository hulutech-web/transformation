<template>
  <div class="flex flex-col">
    <div style="display:flex;">
      <a-input size="large" placeholder="请输入验证码" v-model="content" class="mr-1"></a-input>
      <img class="captcha" style="height:38px;" :src="captcha.img" @click="get"/>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      captcha: {},
      content: ''
    }
  },
  watch: {
    content(n) {
      this.$emit('input', {content: this.content, key: this.captcha.key})
    },
    'captcha.key'(n) {
      this.$emit('input', {content: this.content, key: this.captcha.key})
    }
  },
  created() {
    this.get()
  },
  methods: {
    async get() {
      this.captcha = await this.axios.get(`captcha?_` + Math.random())
    }
  }
}
</script>

<style scoped>
.captcha {
  cursor: pointer;
}
</style>>
