<template>
  <div ref='vantaRef'>
    <router-view></router-view>
  </div>
</template>

<script>
import * as THREE from 'three'
import CLOUDS from "vanta/src/vanta.clouds"


/**
 * birds、clouds/clouds2、waves、fog、globe/net/rings
 */
export default {
  beforeDestroy() {
    if (this.vantaEffect) {
      this.vantaEffect.destroy()
    }
  },
  mounted() {
    this.vantaEffect = CLOUDS({
      el: this.$refs.vantaRef,
      THREE: THREE
    })
    this.vantaEffect.setOptions({
      mouseControls: true,
      touchControls: true,
      gyroControls: false,
      minHeight: 200.00,
      minWidth: 200.00,
      speed: 1.50
    })
  },
}
</script>

<style scoped>

</style>
