<template>
  <div>
    <a-card title="充電樁配置信息">
      <a-tabs :default-active-key="0" @change="callback">
        <a-tab-pane :key='index' :tab="tab.title" v-for="(tab,index) in tabs">
          <component v-bind:is="tab.name"/>
        </a-tab-pane>
      </a-tabs>
    </a-card>

  </div>
</template>

<script>

import tabs from './tabs/tabs.js'
import chargingInfo from "./tabs/chargingInfo";
import parkInfo from "./tabs/parkInfo";
import systemSetting from "./tabs/systemSetting";

export default {
  components: {
    parkInfo,
    chargingInfo,
    systemSetting
  },
  data() {
    return {
      tabs: tabs,
      form: {},
    };
  },
  methods: {
    callback() {
    }
  }
}
</script>

<style scoped>
</style>