<template>
    <div class="relative">
        <el-upload
            class="hd-image-uploader"
            :action="action"
            :show-file-list="false"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload"
            :headers="headers"
        >
            <img v-if="imageUrl" :src="imageUrl" class="avatar object-cover" :style="{ width: `${width}px`, height: `${height}px` }" />
            <i v-else class="el-icon-plus hd-image-uploader-icon" :style="{ width: `${width}px`, height: `${height}px` }" />
        </el-upload>
        <i class="fas fa-window-close absolute fa-2x text-white top-2 left-2 cursor-pointer" @click="del"></i>
    </div>
</template>

<script>
export default {
    props: {
        sid: { default: '' },
        value: { type: String },
        type: {
            type: Array,
            default() {
                return ['image/jpeg', 'image/png']
            }
        },
        width: {
            type: Number,
            default: 120
        },
        height: {
            type: Number,
            default: 120
        },
        size: { type: Number, default: 1024 * 1024 * 2 }
    },
    data() {
        return {
            imageUrl: this.value,
            headers:{
                'Authorization': `Bearer `+localStorage.getItem('token'),
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }
    },
    watch: {
        value(n) {
            this.imageUrl = n
        }
    },
    computed: {
        action() {
            return `/api/upload/image`
        },
    },
    methods: {
        //移除上传文件
        del() {
            this.$confirm('确定删除吗?', '温馨提示').then(_ => {
                this.$emit('input', (this.imageUrl = ''))
            })
        },
        handleAvatarSuccess(res, file) {
            this.imageUrl = res.path
            this.$emit('input', this.imageUrl)
        },


        beforeAvatarUpload(file) {
            const isType = this.type.includes(file.type)
            const isSize = file.size < this.size
            if (!isType) {
                this.$message.error('文件类型错误')
            }
            if (!isSize) {
                this.$message.error(`上传文件不能超过${Math.round(this.size / 1024)}KB`)
            }
            return isType && isSize
        }
    }
}
</script>

<style lang="scss">
.hd-image-uploader {
    .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        &:hover {
            border-color: #409eff;
        }
    }
    .hd-image-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        // width: 178px;
        // height: 178px;
        // line-height: 178px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .avatar {
        width: auto;
        // height: 178px;
        display: block;
        background: #f3f3f3;
    }
}
</style>
