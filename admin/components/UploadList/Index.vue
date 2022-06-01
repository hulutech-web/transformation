<template>
    <div class="clearfix">
        <a-upload :action="actionUrl" list-type="picture-card" :file-list="fileList" @preview="handlePreview"
                  @change="handleChange" :headers="headers">
            <div v-if="fileList.length < 8">
                <a-icon type="plus"/>
                <div class="ant-upload-text">
                    图集上传
                </div>
            </div>
        </a-upload>
        <a-modal :visible="previewVisible" :footer="null" @cancel="handleCancel">
            <img alt="example" style="width: 100%" :src="previewImage"/>
        </a-modal>
    </div>
</template>
<script>
function getBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });
}

export default {
    name: 'UploadList',
    props: {
        action: {
            type: String,
        },
        images: {
            type: Array, default: () => {
                return null
            }
        },
        fieldName: {
            type: String
        }
    },
    data() {
        return {
            previewVisible: false,
            previewImage: '',
            fileList: [],
        };
    },
    computed: {
        actionUrl() {
            return this.action ? this.action : `/api/upload/image`;
        },
        headers() {
            return {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }
    },
    mounted() {
        //获取字段名
        if (this.images !== null && Array.isArray(this.images) && this.images.length > 0) {
            // 构造一个images数组对象
            this.fileList = this.images.map(image => {
                return {
                    // 随机整数
                    uid: Math.random(),
                    name: image.split('/')[image.split('/').length - 1],
                    status: 'done',
                    url: image,
                }
            })
            // this.fileList = this.images
        }
    },
    watch: {
        images(n) {
            //返回规定格式的数组
            this.fileList = n.map(image => {
                return {
                    // 随机整数
                    uid: Math.random(),
                    name: image.split('/')[image.split('/').length - 1],
                    status: 'done',
                    url: image,
                }
            })
        }
    },
    methods: {
        handleCancel() {
            this.previewVisible = false;
        },
        async handlePreview(file) {
            if (!file.url && !file.preview) {
                file.preview = await getBase64(file.originFileObj);
            }
            this.previewImage = file.url || file.preview;
            this.previewVisible = true;
        },
        handleChange({file, fileList}) {
            this.fileList = fileList
            if (file.status !== 'uploading') {
                this.$message.success(`成功`);
                let images = [];
                fileList.map(file => {
                    if (file.hasOwnProperty('response')) {
                        images.push(file.response.data.image.path)
                    } else {
                        images.push(file.url)
                    }
                })
                this.$emit("changeImages", {images: images, fieldName: this.fieldName})
            }
        },
    },
};
</script>
<style lang="scss" scoped>

.ant-upload-select-picture-card i {
    font-size: 32px;
    color: #999;
}

.ant-upload-select-picture-card .ant-upload-text {
    margin-top: 8px;
    color: #666;
}
</style>
