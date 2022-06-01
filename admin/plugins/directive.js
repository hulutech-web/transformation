//注册多个全局指令
import Vue from 'vue'
import {message} from 'ant-design-vue'

const copy = {
    bind(el, {value}) {
        el.$value = value
        el.handler = () => {
            if (!el.$value) {
                // 值为空的时候，给出提示。可根据项目UI仔细设计
                console.log('无复制内容')
                return
            }
            // 动态创建 textarea 标签
            const textarea = document.createElement('textarea')
            // 将该 textarea 设为 readonly 防止 iOS 下自动唤起键盘，同时将 textarea 移出可视区域
            textarea.readOnly = 'readonly'
            textarea.style.position = 'absolute'
            textarea.style.left = '-9999px'
            // 将要 copy 的值赋给 textarea 标签的 value 属性
            textarea.value = el.$value
            // 将 textarea 插入到 body 中
            document.body.appendChild(textarea)
            // 选中值并复制
            textarea.select()
            const result = document.execCommand('Copy')
            if (result) {
                message.success('复制成功')
            }
            document.body.removeChild(textarea)
        }
        // 绑定点击事件，就是所谓的一键 copy 啦
        el.addEventListener('click', el.handler)
    },
    // 当传进来的值更新的时候触发
    componentUpdated(el, {value}) {
        el.$value = value
    },
    // 指令与元素解绑的时候，移除事件绑定
    unbind(el) {
        el.removeEventListener('click', el.handler)
    },
}


const longpress = {
    bind: function (el, binding, vNode) {
        if (typeof binding.value !== 'function') {
            throw 'callback must be a function'
        }
        // 定义变量
        let pressTimer = null
        // 创建计时器（ 2秒后执行函数 ）
        let start = (e) => {
            if (e.type === 'click' && e.button !== 0) {
                return
            }
            if (pressTimer === null) {
                pressTimer = setTimeout(() => {
                    handler()
                }, 1000)
            }
        }
        // 取消计时器
        let cancel = (e) => {
            if (pressTimer !== null) {
                clearTimeout(pressTimer)
                pressTimer = null
            }
        }
        // 运行函数
        const handler = (e) => {
            binding.value(e)
        }
        // 添加事件监听器
        el.addEventListener('mousedown', start)
        el.addEventListener('touchstart', start)
        // 取消计时器
        el.addEventListener('click', cancel)
        el.addEventListener('mouseout', cancel)
        el.addEventListener('touchend', cancel)
        el.addEventListener('touchcancel', cancel)
    },
    // 当传进来的值更新的时候触发
    componentUpdated(el, {value}) {
        el.$value = value
        message.success('更新成功')
    },
    // 指令与元素解绑的时候，移除事件绑定
    unbind(el) {
        el.removeEventListener('click', el.handler)
    },
}

//防抖函数

const debounce = {
    inserted: function (el, binding) {
        let timer
        el.addEventListener('keyup', () => {
            if (timer) {
                clearTimeout(timer)
            }
            timer = setTimeout(() => {
                binding.value()
            }, 1000)
        })
    },
}



//#region  //场景一、指定角色可操作（当前用户的角色）


function checkRole(key) {
    //从本地缓存中读取
    const role = window.localStorage.getItem('role')
    if(role===key){
        return true
    }else{
        return false
    }
}
const onlyrole = {
    inserted: function (el, binding) {
        let permission = binding.value // 获取到 v-permission的值
        if (permission) {
            let hasPermission = checkRole(permission)
            if (!hasPermission) {
                // 没有权限 移除Dom元素
                el.parentNode && el.parentNode.removeChild(el)
            }
        }
    },
}
//案例 v-onlyrole="'Admin'"
//#endregion


//#region //场景二、包含角色列表操作 （传入数组）
function checkRoles(roleArr) {
    //当前用户的角色
    const curRole = window.localStorage.getItem('role')
//如果当前用户的角色包含在roleArr中返回真，否则返回假
    let index = roleArr.indexOf(curRole)
    if (index > -1) {
        return true // 有权限
    } else {
        return false // 无权限
    }
}
const roles = {
    inserted: function (el, binding) {
        let permission = binding.value // 获取到 v-permission的值
        if (permission) {
            let hasPermission = checkRoles(permission)
            if (!hasPermission) {
                // 没有权限 移除Dom元素
                el.parentNode && el.parentNode.removeChild(el)
            }
        }
    },
}
//案例  v-roles="['Admin','User']"
//#endregion

//#region 场景三、排除某些角色（传入数组）
function excludeRoles(roleArr) {
    const curRole = window.localStorage.getItem('role')
    let index = roleArr.indexOf(curRole)
    if (index > -1) {
        return false // 无权限
    } else {
        return true // 有权限
    }
}
const excluderoles = {
    inserted: function (el, binding) {
        let permission = binding.value // 获取到 v-permission的值
        if (permission) {
            let hasPermission = excludeRoles(permission)
            if (!hasPermission) {
                // 没有权限 移除Dom元素
                el.parentNode && el.parentNode.removeChild(el)
            }
        }
    },
}


/**
 * <div class="btns">
 <!-- 显示 -->
 <button v-permission="'1'">权限按钮1</button>
 <!-- 不显示 -->
 <button v-permission="'10'">权限按钮2</button>
 </div>

 */


/**
 * <template>
 <div v-waterMarker="{text:'lzg版权所有',textColor:'rgba(180, 180, 180, 0.4)'}"></div>
 </template>

 */
const draggable = {
    inserted: function (el) {
        el.style.cursor = 'move'
        el.onmousedown = function (e) {
            let disx = e.pageX - el.offsetLeft
            let disy = e.pageY - el.offsetTop
            document.onmousemove = function (e) {
                let x = e.pageX - disx
                let y = e.pageY - disy
                let parentNode = el.parentNode
                let maxX = parentNode.clientWidth - parseInt(window.getComputedStyle(el).width)
                let maxY = parentNode.clientHeight - parseInt(window.getComputedStyle(el).height)
                if (x < 0) {
                    x = 0
                } else if (x > maxX) {
                    x = maxX
                }

                if (y < 0) {
                    y = 0
                } else if (y > maxY) {
                    y = maxY
                }

                el.style.left = x + 'px'
                el.style.top = y + 'px'
            }
            document.onmouseup = function () {
                document.onmousemove = document.onmouseup = null
            }
        }
    },
}
/**
 * <template>
 <div class="el-dialog" v-draggable></div>
 </template>

 */

Vue.directive('draggable', draggable);
Vue.directive('copy', copy)
Vue.directive('debounce', debounce)
Vue.directive('longpress', longpress)
//仅某角色
Vue.directive('onlyrole', onlyrole)
//包含某些角色
Vue.directive('roles', roles)
//排除某些角色
Vue.directive('excluderoles', excluderoles)
