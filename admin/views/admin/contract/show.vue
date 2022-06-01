<template>
  <div>

    <a-card title="预览合同">
      <a-button @click="doAction">预览</a-button>
      <Doc ref="doc" :url="url"/>
    </a-card>
  </div>
</template>

<script>
import Doc from '#/components/Docx'

export default {
  components: {Doc},
  data() {
    return {
      id: this.$route.params.id,
      url: ''
    }
  },
  path: `/admin/contract/:id/show`,
  methods: {
    async doAction() {
      await this.axios.post(`admin/contract/${this.id}/preview`).then(_ => {
        this.url = `/doc/output/${this.id}.docx`
        this.$nextTick(() => {
          this.$refs.doc.goPreview()
        })
      })
    }
  }
}
</script>

<style scoped>

</style>
