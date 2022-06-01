<template>
  <div>
    <a-row :gutter="[16,16]">
      <a-col :span="12">
        <a-card title="权限配置">
          <a-card hoverable style="margin: 10px;display: inline-block">
            <a-card>
              <template slot="actions" class="ant-card-actions">

                <a-button type="primary" @click="initMenus">初始化菜单</a-button>
              </template>
              <a-card-meta title="菜单配置" style="min-height: 150px;min-width: 200px;max-width:250px;"
                           description="生成初始化菜单，与权限一一对应">

              </a-card-meta>
            </a-card>
          </a-card>
          <a-card hoverable style="margin: 10px;display: inline-block">
            <a-card>
              <template slot="actions" class="ant-card-actions">
                <a-button type="primary" @click="initPermission">初始化权限</a-button>
              </template>
              <a-card-meta title="权限配置" style="min-height: 150px;min-width: 200px;max-width:250px;"
                           description="初始化权限，控制左侧菜单显示">

              </a-card-meta>
            </a-card>
          </a-card>
        </a-card>
      </a-col>


      <a-col :span="12">
        <a-card title="系统配置">
          <a-card hoverable style="margin: 10px;display: inline-block">
            <a-card>
              <template slot="actions" class="ant-card-actions">

                <a-button type="primary" @click="changeTheme">主题设置</a-button>
              </template>
              <a-card-meta title="主题设置" style="min-height: 150px;min-width: 200px;max-width:250px;"
                           description="主题设置">

              </a-card-meta>
            </a-card>
          </a-card>

        </a-card>
      </a-col>

    </a-row>

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
