require('./bootstrap')
import Vue from 'vue'
import App from './App.jsx'
import router from './router'
import store from './store'
import hdcms from './plugins/hdcms'

Vue.use(hdcms)

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
