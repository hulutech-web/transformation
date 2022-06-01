<template>


  <div class="camera-box">

    <video id="video" :width="videoWidth" :height="videoHeight" v-show="!imgSrc"></video>

    <canvas id="canvas" :width="videoWidth" :height="videoHeight" v-show="imgSrc"></canvas>

    <p class="camera-p">{{ !imgSrc ? '提示：请将头像居中按"拍照"键确认' : '' }}</p>

    <a-button type="primary" @click="setImage" v-if="!imgSrc" class="camera-btn">拍照</a-button>

    <a-button type="primary" v-if="imgSrc" @click="setFileUpload" class="camera-btn">上传</a-button>

  </div>
</template>

<script>
export default {
  path: `/admin/user/:id/camera`,
  props: {
    //【必选】CameraDialog弹窗显示状态
    show: {type: Boolean},
    //【可选】配合原生input本地上传，用于替换时执行删除
    deleteData: {type: Object}
  },
  data() {
    return {
      videoWidth: '401',
      videoHeight: '340',
      thisCancas: null,
      thisContext: null,
      thisVideo: null,
      imgSrc: ``,
    }
  },
  mounted() {
    this.getCompetence()
  },
  methods: {
    getCompetence() {
      var _this = this
      this.thisCancas = document.getElementById('canvas')
      this.thisContext = this.thisCancas.getContext('2d')
      this.thisVideo = document.getElementById('video')
      // 旧版本浏览器可能根本不支持mediaDevices，我们首先设置一个空对象
      if (navigator.mediaDevices === undefined) {
        navigator.mediaDevices = {}
      }
      // 一些浏览器实现了部分mediaDevices，我们不能只分配一个对象
      // 使用getUserMedia，因为它会覆盖现有的属性。
      // 这里，如果缺少getUserMedia属性，就添加它。
      if (navigator.mediaDevices.getUserMedia === undefined) {
        navigator.mediaDevices.getUserMedia = function (constraints) {
          // 首先获取现存的getUserMedia(如果存在)
          var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.getUserMedia
          // 有些浏览器不支持，会返回错误信息
          // 保持接口一致
          if (!getUserMedia) {
            return Promise.reject(new Error('getUserMedia is not implemented in this browser'))
          }
          // 否则，使用Promise将调用包装到旧的navigator.getUserMedia
          return new Promise(function (resolve, reject) {
            getUserMedia.call(navigator, constraints, resolve, reject)
          })
        }
      }
      var constraints = {
        audio: false,
        video: {width: this.videoWidth, height: this.videoHeight, transform: 'scaleX(-1)'}
      }
      navigator.mediaDevices.getUserMedia(constraints).then(function (stream) {
        // 旧的浏览器可能没有srcObject
        if ('srcObject' in _this.thisVideo) {
          _this.thisVideo.srcObject = stream
        } else {
          // 避免在新的浏览器中使用它，因为它正在被弃用。
          _this.thisVideo.src = window.URL.createObjectURL(stream)
        }
        _this.thisVideo.onloadedmetadata = function (e) {
          _this.thisVideo.play()
        }
      }).catch(err => {
        console.log(err)
      })
    },
    setImage() {
      var _this = this
      // 点击，canvas画图
      _this.thisContext.drawImage(_this.thisVideo, 0, 0, _this.videoWidth, _this.videoHeight)
      // 获取图片base64链接
      var image = this.thisCancas.toDataURL('image/png')
      _this.imgSrc = image
      // console.log(_this.imgSrc)
      // this.$emit('refreshDataList', this.imgSrc)
    },
    dataURLtoFile(dataurl, filename) {
      var arr = dataurl.split(',')
      var mime = arr[0].match(/:(.*?);/)[1]
      var bstr = atob(arr[1])
      var n = bstr.length
      var u8arr = new Uint8Array(n)
      while (n--) {
        u8arr[n] = bstr.charCodeAt(n)
      }
      return new File([u8arr], filename, {type: mime})
    },
    stopNavigator() {
      this.thisVideo.srcObject.getTracks()[0].stop()
    },
    //上传图片
    setFileUpload() {
      //编辑档案-上传人脸照片
      if (this.deleteData) {
        if (this.deleteData.imagePath) {
          deleteFileUpload({id: this.deleteData.id, filePath: this.deleteData.imagePath})
              .then(res => {
                setFileUpload({image: this.imgSrc})
                    .then(res => {
                      this.$emit('fileUpload', res.retData.filePath, res.retData.imagePath)
                      addUserCard({
                        userId: this.deleteData.userid,
                        cardType: this.deleteData.cardType,
                        userAuditInfo: res.retData.imagePath
                      })
                          .then(res => {
                            this.$message({message: "上传成功", type: "success"})
                          })
                          .catch(err => {
                            console.log(err)
                          })
                    })
                    .catch(err => {
                      console.log(err)
                    })
              })
              .catch(err => {
                console.log(err)
              })
        } else {
          setFileUpload({image: this.imgSrc})
              .then(res => {
                this.$emit('fileUpload', res.retData.filePath, res.retData.imagePath)
                addUserCard({
                  userId: this.deleteData.userid,
                  cardType: this.deleteData.cardType,
                  userAuditInfo: res.retData.imagePath
                })
                    .then(res => {
                      this.$message({message: "上传成功", type: "success"})
                    })
                    .catch(err => {
                      console.log(err)
                    })
              })
              .catch(err => {
                console.log(err)
              })
        }
      } else {
        //添加住户-上传人脸照片
        setFileUpload({image: this.imgSrc})
            .then(res => {
              // console.log(res)
              this.$message({message: "上传成功", type: "success"})
              this.$emit('fileUpload', res.retData.filePath, res.retData.imagePath)
            })
            .catch(err => {
              console.log(err)
            })
      }
    },
  },
  watch: {
    show(val) {
      if (val) {
        this.imgSrc = ``
        this.getCompetence()
      } else {
        this.stopNavigator()
      }
    },
  }
}
</script>

<style lang="less" scoped>
.camera-box {
  margin: 0 auto;
  text-align: center;
}

.camera-p {
  height: 17px;
  line-height: 17px;
  font-size: 12px;
  font-family: "PingFang SC";
  font-weight: 400;
  color: rgba(154, 154, 154, 1);
  text-align: left;
}

.camera-btn {
  margin-top: 20px;
}

</style>
