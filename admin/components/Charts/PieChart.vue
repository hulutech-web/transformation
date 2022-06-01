<template>
  <div>
    <ve-pie :data="pieData" width="400px"></ve-pie>
  </div>
</template>

<script>
import VePie from 'v-charts/lib/pie.common'

export default {
  components: {VePie},
  props: ['pieData'],
}
</script>

<style scoped>

</style>