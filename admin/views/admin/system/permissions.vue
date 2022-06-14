<template>
  <div>

    <a-card title="权限配置" size="small">
      <a-card size="small" hoverable style="display: inline-block">
        <template slot="actions" class="ant-card-actions">

          <a-button type="primary" @click="initMenus">初始化菜单</a-button>
        </template>
        <a-card-meta title="菜单配置" style="height: 150px;width: 160px;"
                     description="生成初始化菜单，与权限一一对应">
        </a-card-meta>

      </a-card>
      <a-card size="small" hoverable style="display: inline-block">
        <template slot="actions" class="ant-card-actions">
          <a-button type="primary" @click="initPermission">初始化权限</a-button>
        </template>
        <a-card-meta title="权限配置" style="height: 150px;width: 160px;"
                     description="初始化权限，控制左侧菜单显示">

        </a-card-meta>
      </a-card>
      <a-card size="small" hoverable style="display: inline-block">
        <template slot="actions" class="ant-card-actions">
          <a-button type="primary" @click="changeTheme">主题设置</a-button>
        </template>
        <a-card-meta title="主题设置" style="height: 150px;width: 160px;"
                     description="主题设置，根据需要调整左侧菜单明暗">
        </a-card-meta>
      </a-card>
    </a-card>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {title: 'ccc'},
      isAdmin: false,
    }
  },
  created() {
    let user = JSON.parse(localStorage.getItem('user'))
    if (user.id == 1) {
      this.isAdmin = true
    }
  },
  methods: {
    async initMenus() {
      await this.axios.post('admin/menus')
    },
    async initPermission() {
      await this.axios.post('admin/permission/init')
    },
    press() {
      this.$message.success('长按了')
    },
    changeTheme() {
      //获取state中的主题
      let theme = this.$store.state.theme
      //切换主题
      if (theme == 'dark') {
        this.$store.commit('theme', 'light')
      } else {
        this.$store.commit('theme', 'dark')
      }
    }
  }
}
</script>

<style scoped>
.parent {
  position: absolute;
  top: 0;
}

.drag {
  width: 100px;
  height: 100px;
  background: red;
  position: absolute;
  top: 0;
  left: 0;
}

</style>
