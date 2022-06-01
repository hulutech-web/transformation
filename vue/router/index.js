import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from '../router/routes'

Vue.use(VueRouter)

const router = new VueRouter({
    routes,
    mode: 'history'
})
const user = JSON.parse(localStorage.getItem('user'))
router.beforeEach(async (to, from, next) => {
   //没有user时，只能访问首页
   if(!user && to.path !== '/'){
       next('/')
   }
   //有user时，可以访问任何页面

   next()
})
export default router
