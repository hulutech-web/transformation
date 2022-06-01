import el from 'element-ui'
import axios from 'axios'
import Vue from 'vue'
import store from '../store'
axios.defaults.withCredentials = true
const _axios = axios.create({ baseURL: `/api`, timeout: 20000 })
window.axios = Vue.axios = Vue.prototype.axios = _axios
//请求拦截
_axios.interceptors.request.use(
    function(config) {
        //清除验证信息
        if (config.method != 'get') {
            store.commit('errors')
        }
        if (config.url[0] == '/') config.baseURL = ''
        // const token = window.localStorage.getItem('token')
        // if (token) {
        //     config.headers.Authorization = `Bearer ${token}`
        // }
        return config
    },
    function(error) {
        return Promise.reject(error)
    }
)
//响应拦截
_axios.interceptors.response.use(
    //成功拦截
    function(response) {
        let { message } = response.data
        if (message) {
            el.Message({
                message,
                type: 'success'
            })
        }
        return response.data
    },
    //错误拦截
    function(error) {
        let { status, data } = error.response
        switch (status) {
            case 422:
                el.Message({
                    message: data.message,
                    type: 'error'
                })
                store.commit('errors', data.errors)
                break
            case 401:
                location.href = '/'
                break
            case 429:
                el.Message.error('请求次数过多')
                break
            default:
                el.Message.error(data.message)
        }
        return Promise.reject(error)
    }
)

export default _axios
