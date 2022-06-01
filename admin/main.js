require('./bootstrap');
import Vue from 'vue';
import 'ant-design-vue/dist/antd.css';
import './config/components_use'
import App from './App';
import router from './router';
import vueEsign from 'vue-esign'
import store from "./store";


//引入图表库
Vue.use(vueEsign)

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
