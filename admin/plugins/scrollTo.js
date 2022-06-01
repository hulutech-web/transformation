import Vue from 'vue'

const scrollTo = (el) => {
    setTimeout(() => {
        const element = document.querySelector(el)
        if (element) {
            const y = element.getBoundingClientRect().top + document.documentElement.scrollTop
            document.documentElement.scroll({top: y, behavior: 'smooth'})
        }
    })
}
Vue.prototype.$scollTo = scrollTo
