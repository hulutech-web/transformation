<template>
  <div>
    <ve-line :data="lineData" width="400px"></ve-line>
  </div>
</template>

<script>
import VeLine from 'v-charts/lib/line.common'
export default {
  components: {VeLine},
  props: ['lineData'],
}
</script>