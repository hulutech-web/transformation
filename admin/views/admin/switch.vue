<template>
  <div>
    <a-card title="平台选择">
      <a-row :gutter="[16,16]">
        <a-col :span="12">
          <a-card hoverable style="background: #5d8af3;">
            <span style="font-size:36px;color:white;">汽车报告</span>
          </a-card>
        </a-col>
        <a-col :span="12">
          <a-card hoverable style="background: #bf7326">
            <span style="font-size:36px;color:white;">充电桩报告</span>
          </a-card>
        </a-col>
      </a-row>
    </a-card>
  </div>
</template>

<script>
export default {
  meta: {title: "切换页"},
}
</script>

<style scoped>
</style>