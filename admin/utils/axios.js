import axios from 'axios'
import {notification} from 'ant-design-vue'
import Vue from 'vue'

axios.defaults.withCredentials = true
const _axios = axios.create({baseURL: `/api`, timeout: 20000})
window.axios = Vue.axios = Vue.prototype.axios = _axios
//请求拦截
_axios.interceptors.request.use(
    function (config) {
        //清除验证信息
        if (config.method != 'get') {
            // store.commit('errors')
        }
        if (config.url[0] == '/') config.baseURL = ''
        const token = window.localStorage.getItem('token')
        if (token) {
            config.headers.Authorization = `Bearer ${token}`
        }
        return config
    },
    function (error) {
        return Promise.reject(error)
    }
)
//响应拦截
_axios.interceptors.response.use(
    //成功拦截
    function (response) {
        let {message} = response.data

        if (message) {
            notification.success({
                message,
                duration: 2
            })
        }
        return response.data
    },
    //错误拦截
    function (error) {
        let {status, data} = error.response
        switch (status) {
            case 422:
                console.log(data)
                notification.error({
                    message: data.errors[Object.keys(data.errors)[0]],
                    duration: 2
                })
                break
            case 401:
                notification.error({
                    message: '登录已过期，请重新登录',
                    duration: 2
                })
                location.href = '/auth/login'
                localStorage.clear();
                break
            case 429:
                notification.error({
                    message: '请求次数过多，请稍后再试',
                    duration: 2
                })
                break
            default:
                notification.error({
                    message: data.message,
                    duration: 2
                })
        }
        return Promise.reject(error)
    }
)

export default _axios
