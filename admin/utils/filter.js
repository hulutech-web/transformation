import Vue from 'vue'
import convertCurrency from './convertCurrency'

var moment = require('moment');
moment.locale('zh-cn');
//内容截断
Vue.filter('truncate', function (value, len = 55, ex = '...') {
    if (value) {
        return value.length > len ? value.substr(0, len) + ex : value
    }
})

//显示几天前
Vue.filter('fromNow', function (value) {
    return moment(value).fromNow()
})

//格式化日期
Vue.filter('dateFormat', (value, format = 'YYYY-MM-DD hh:mm') => {
    return moment(value).format(format)
})

//数字转人民币大写
Vue.filter('moneyFormat', (value) => {
    return convertCurrency(value)
})