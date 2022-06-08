<template>
  <a-upload
      name="file"
      :multiple="true"
      :action="url"
      :headers="headers"
      @change="handleChange"
  >
    <a-button>
      <a-icon type="upload"/>
      點擊上傳
    </a-button>
  </a-upload>
</template>

<script>
export default {
  props: ['action'],
  data() {
    return {
      headers: {
        Authorization: `Bearer ` + window.localStorage.getItem('token'),
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
    }
  },
  created() {
    console.log(this.url)
  },
  computed: {
    //當前網站的hostname
    url() {
      return this.action ? this.action : `http://${window.location.hostname}/api/import/park`
    }
  },
  methods: {
    handleChange(info) {
      if (info.file.status !== 'uploading') {
        // console.log(info.file, info.fileList);
      }
      if (info.file.status === 'done') {
        this.$message.success(`${info.file.name} file uploaded successfully`);
      } else if (info.file.status === 'error') {
        // console.log('error======', info.file);
        this.$message.error(`${info.file.name}導入失敗。[${info.file.response.message}]`);
      }
    },
  }
}
</script>

<style scoped>

</style>