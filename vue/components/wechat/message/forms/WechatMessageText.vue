<template>
    <el-form :model="form" ref="form" label-width="100px" :inline="false" size="normal">
        <hd-wechat-message-rule :form="form" />
        <el-card shadow="nerver" :body-style="{ padding: '20px' }">
            <div slot="header">
                回复文本
            </div>
            <div v-for="(content, index) in form.content" :key="index" class="mt-2 relative">
                <el-input type="textarea" v-model="form.content[index]"></el-input>
                <i
                    class="fas fa-times-circle absolute -top-3 -right-2 text-lg text-gray-500 hover:text-gray-800 duration-300 cursor-pointer"
                    @click="del(index)"
                ></i>
            </div>
            <hd-form-error name="content" />
            <el-button size="mini" @click="add" class="mt-2">添加回复</el-button>
        </el-card>

        <el-button type="primary" @click="onSubmit" :disabled="isSubmit" v-loading="isSubmit" class="block mt-3">保存提交</el-button>
    </el-form>
</template>

<script>
import mixin from './mixin'
export default {
    mixins: [mixin],
    data() {
        return {
            field: { type: 'text', content: [] }
        }
    },
    methods: {
        add() {
            this.form.content.push('')
        }
    }
}
</script>
