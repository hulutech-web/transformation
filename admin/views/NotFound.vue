<template>
    <result status="404" title="404" sub-title="SORRY！ 页面不存在">
        <template #extra>
            <router-link :to="{ name: 'auth.login' }">
                <a-button type="primary">返回首页</a-button>
            </router-link>
        </template>
    </result>
</template>
<script>
import {Result} from 'ant-design-vue'
export default {
    components:{Result},
    route:false
}
</script>
