<template>
  <a-upload
      name="file"
      list-type="picture-card"
      class="avatar-uploader"
      :show-upload-list="false"
      :action="action"
      :headers="headers"
      :before-upload="beforeUpload"
      @change="handleChange"
  >
    <img v-if="imageUrl" class="" :src="imageUrl" class="avatar" alt="avatar"/>
    <div v-else>
      <a-icon :type="loading ? 'loading' : 'plus'"/>
      <div class="ant-upload-text">
        Upload
      </div>
    </div>
  </a-upload>
</template>
<script>

export default {
  props: {
    value: {type: String},
  },
  data() {
    return {
      loading: false,
      imageUrl: this.value,
      headers: {
        Authorization: `Bearer ` + window.localStorage.getItem('token'),
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    };
  },
  created() {
    console.log('upload token:', localStorage.getItem('token'))
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
    handleChange({file}) {
      if (file.status === 'uploading') {
        this.loading = true;
        return;
      }
      if (file.status === 'done') {
        this.imageUrl = file.response.data.image.path
        this.$emit('input', this.imageUrl)
      }
    },
    beforeUpload(file) {
      const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png';
      if (!isJpgOrPng) {
        this.$message.error('You can only upload JPG file!');
      }
      const isLt2M = file.size / 1024 / 1024 < 2;
      if (!isLt2M) {
        this.$message.error('Image must smaller than 2MB!');
      }
      return isJpgOrPng && isLt2M;
    },
  },
};
</script>
<style>
.avatar {
  width: 128px;
  height: 128px;
}

.avatar-uploader > .ant-upload {
  width: 128px;
  height: 128px;
}

.ant-upload-select-picture-card i {
  font-size: 32px;
  color: #999;
}

.ant-upload-select-picture-card .ant-upload-text {
  margin-top: 8px;
  color: #666;
}

</style>
