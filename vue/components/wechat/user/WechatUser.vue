<template>
    <div>
        <el-alert effect="light" closable class="mb-2"> 正在管理【{{ wechat.title }}】公众号的粉丝 </el-alert>

        <div class="mt-3 flex">
            <el-input placeholder="请输入粉丝昵称" v-model="keyword"> </el-input>
            <el-button-group class="flex ml-2">
                <el-button type="default" size="mini" @click="load()">搜索粉丝</el-button>
                <el-button type="primary" size="mini" @click="sync('')">同步粉丝</el-button>
            </el-button-group>
        </div>
        <hd-wechat-user-list :users="users.data" v-if="users.meta" #default="{user}" v-bind="$attrs">
            <slot :user="user"> </slot>
        </hd-wechat-user-list>
        <el-pagination
            @current-change="load"
            :page-size="10"
            layout="total, prev, pager, next"
            :total="users.meta.total"
            background
            :hide-on-single-page="true"
            v-if="users.meta"
            class="mt-3"
        >
        </el-pagination>
    </div>
</template>

<script>
export default {
    props: ['wechat'],
    data() {
        return {
            loading: true,
            users: [],
            isSync: false,
            keyword: '',
            page: 1
        }
    },
    watch: {
        wechat: {
            handler(wechat) {
                this.wechat = wechat
                this.load()
            },
            immediate: true
        }
    },
    // async created() {
    //     this.load()
    // },
    methods: {
        async load(page) {
            this.page = page || this.page
            this.loading = true
            this.users = await axios.get(`site/${this.wechat.site_id}/wechat/${this.wechat.id}/user?page=${this.page}&keyword=${this.keyword}`)
            this.loading = false
        },
        //同步粉丝
        async sync(nextOpenid = '') {
            this.isSync = true
            //首次同步显示信息
            if (!nextOpenid) this.$message('粉丝同步中...')
            //同步地址
            let url = `site/${this.query('sid')}/wechat/${this.query('wid')}/user/sync` + (nextOpenid && `?next_openid=${nextOpenid}`)
            const response = await axios.get(url)
            //下次同步
            if (response.data.next_openid) this.sync(response.data.next_openid)
            this.load()
            this.isSync = false
        }
    }
}
</script>

<style lang="scss"></style>
