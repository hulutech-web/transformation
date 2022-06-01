<template>

  <div>
    <vue-esign ref="esign" :width="800" :height="300" :isCrop="isCrop" :lineWidth="lineWidth" :lineColor="lineColor"
               :bgColor.sync="bgColor"/>
    <div>
      <img src="sign.png" alt="">
    </div>
    <a-button type="primary" @click="handleReset">清空画板</a-button>
    <a-button type="danger" @click="handleGenerate">生成图片</a-button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      lineWidth: 6,
      lineColor: '#000000',
      bgColor: '',
      resultImg: '',
      isCrop: false
    }
  },
  methods: {
    handleReset() {
      this.$refs.esign.reset()
    },
    handleGenerate() {
      this.$refs.esign.generate().then(res => {
        this.resultImg = this.dataURLtoFile(res, 'sign.png')

        console.log(this.resultImg)
      }).catch(err => {
        alert(err) // 画布没有签字时会执行这里 'Not Signned'
      })
    },
    //base64转成图片
    dataURLtoFile(dataurl, filename) {
      var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
          bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
      while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
      }
      return new File([u8arr], filename, {type: mime});
    }
  }

}
</script>

<style scoped>

</style>

