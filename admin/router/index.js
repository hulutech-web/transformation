import routes from "./routes";
import Vue from 'vue'
import VueRouter from 'vue-router'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes
})
const isLogin = !!localStorage.getItem('token')

router.beforeEach((to, from, next) => {
    NProgress.start();
    //如果已经登录则执行下一步
    //如果未登录跳转到登录页/auth/login
    if (to.path === '/auth/login' && isLogin) {
        next({path: '/admin/index'})
    } else if (to.path === '/auth/login' && !isLogin) {
        next()
    } else {
        next()
    }
    next();

})
router.afterEach(() => {
    NProgress.done();
})
export default router
