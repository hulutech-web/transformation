<template>
    <div>
        <div>
            <el-input placeholder="请输入图形验证码" v-model="content"></el-input>
            <img style="margin-top: 2px;height: 28px;" :src="captcha.img"  @click="get"/>
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
            this.captcha = await this.axios.get(`front/captcha?_` + Math.random())
        }
    }
}
</script>

<style></style>
