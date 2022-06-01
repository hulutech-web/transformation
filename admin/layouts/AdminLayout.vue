<template>

  <a-layout id="components-layout-demo-side" style="min-height: 100vh">

    <a-layout-sider v-model="collapsed" collapsible :theme="theme">
      <div style="max-width:200px;text-align: center;padding:20px 0;">
        <span style="font-size: 18px;text-align: center;color: #f8a326;">楼盘管理系统</span>
      </div>
      <Menu :menus="menus"></Menu>
    </a-layout-sider>
    <a-layout>
      <!--      id="build"的作用是当页面跳转时scrollTo该位置-->
      <a-layout-header class="ant-pro-global-header" style="background: #fff; padding: 0;" id="build">
        <div style="display:flex;justify-content:space-between;padding: 0  24px;">
          <div @click="fresh" class="icon_hold">
            <a-icon type="reload" :style="{ fontSize: '20px' }"/>
          </div>
          <div>
            <span style="margin-right:10px;">角色：{{ (role && role.title) ? role.title : '暂无' }}</span>
            <a-dropdown>
              <Avatar shape="square" size="large" style="cursor: pointer"
                      :style="{ backgroundColor: 'red', verticalAlign: 'middle' }">
                {{ user.name }}
              </Avatar>

              <a-menu slot="overlay">
                <a-menu-item>
                  <a href="javascript:;" @click="logout">退出登录</a>
                </a-menu-item>
              </a-menu>
            </a-dropdown>
            <Icon type="caret-down"/>
          </div>
        </div>
      </a-layout-header>
      <div
          style="min-height:80px;width:100%;background:white;padding:16px 24px 16px 24px;box-sizing: border-box;">
        <a-breadcrumb>
          <a-breadcrumb-item v-for="(breadcrumb, index) in Breadcrumbs" :key="index">
            {{ breadcrumb.title }}
          </a-breadcrumb-item>
        </a-breadcrumb>
        <div style="margin-top:6px;" v-if="Breadcrumbs[Breadcrumbs.length - 1]">
          <span>
          {{ Breadcrumbs[Breadcrumbs.length - 1]['description'] }}
          </span>
        </div>
      </div>
      <a-layout-content style="margin: 16px 16px">

        <div style="padding: 24px; background: #fff;minHeight: calc(100vh - 270px)">
          <a-spin :spinning="spinning">
            <router-view></router-view>
          </a-spin>
        </div>
      </a-layout-content>
      <a-layout-footer style="text-align: center">
        楼盘管理系统 ©2022 Created by yh
      </a-layout-footer>
      <a-back-top/>
    </a-layout>
  </a-layout>
</template>
<script>
import Menu from "./menu/Menu";
import Cascader from '../utils/Cascader';
import {Avatar, Icon} from 'ant-design-vue'
import img from '#/assets/images/logo.png';

export default {
  meta: {title: '首页'},
  components: {Menu, Avatar, Icon},
  data() {
    return {
      img: img,
      spinning: false,
      collapsed: false,
      menus: [],

      permissions: [],
      role: null,
      //当前路由的名字
      Breadcrumbs: [],
      user: JSON.parse(localStorage.getItem('user')),
      theme: this.$store.state.theme,
      id: '',

    };
  },
  created() {
    this.getMenus()
    this.getCurrentUserPermissions()
    this.saveRole()
    this.getAllRoles()
    this.$watermark.set(this.user.name + '-' + this.user.mobile.substr(7), this.$refs.content)
  },
  //页面卸载时
  beforeDestroy() {
    this.$watermark.remove(this.id)
    // //离开当前页面时，删除水印
    // this.$router.beforeEach((to, from, next) => {
    //   this.$watermark.remove(id)
    //   next()
    // })
  },
  watch: {
    $route: {
      handler(n) {
        this.generateBreadcrumb()
      },
      immediate: true
    },
    '$store.state.theme'(n) {
      this.theme = n
    }
    //立即更新
  },
  methods: {
    async getMenus() {
      this.menus = await this.axios.post('menu/list')
      //通过store存储menus
      this.$store.commit('menus', this.menus)
    },
    fresh() {
      this.spinning = true
      this.getMenus().then(_ => {
        this.spinning = false
        this.$message.info('刷新成功')
      })
    },
    generateBreadcrumb() {
      let name = this.$route.name
      let menus = this.menus
      //树形结构逆向查找name
      let cascaded = new Cascader(menus, name)
      cascaded.getNodeRoute(menus, name)
      this.Breadcrumbs = cascaded.outputArr
    },
    logout() {
      this.axios.post("admin/user/logout").then(res => {
        this.$message.success('退出成功')
        //清空所有localStorage
        localStorage.clear()
        location.href = '/auth/login'
      })
    },
    async getCurrentUserPermissions() {
      this.permissions = await this.axios.post('admin/defaultPermission')
      this.$store.commit('permissions', this.permissions)
    },
    //获取用户角色
    async saveRole() {
      let role = await this.axios.post(`admin/user/${this.user.id}/role`)
      if (role) {
        this.role = role
        //缓存角色
        localStorage.setItem('role', this.role.name)
        //状态管理
        this.$store.commit('role', this.role.name)
      }
    },
    async getAllRoles() {
      let roles = await this.axios.get("admin/role")
      //缓存所有角色
      localStorage.setItem('roles', JSON.stringify(roles))
      this.$store.commit('roles', roles)
    }
  }
};
</script>

<style lang="scss">
#components-layout-demo-side .logo {
  height: 32px;
  background: rgba(255, 255, 255, 0.2);
  margin: 16px;
}

.ant-pro-global-header {
  position: relative;
  height: 64px;
  padding: 0;
  background: #fff;
  -webkit-box-shadow: 0 1px 4px rgb(0 21 41 / 8%);
  box-shadow: 0 1px 4px rgb(0 21 41 / 8%);
}

.icon_hold {
  text-align: center;
  cursor: pointer;
  height: 64px;
  width: 64px;

  &:hover {
    //    旋转180度
    transform: rotate(360deg);
    //延时1s
    transition: all .5s;
  }
}
</style>
