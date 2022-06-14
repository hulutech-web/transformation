<template>
  <div>
    <a-card title="角色管理" size="small">
      <template #extra>
        <a-button slot="extra" v-if="disabled" disabled>初始化</a-button>
        <a-button slot="extra" v-else type="primary" @click="initRoles">初始化</a-button>
      </template>
      <a-card size="small" hoverable style="display: inline-block;margin:5px;box-sizing: border-box;"
              v-for="(role,index) in roles"
              :key="index">

        <a-card-meta :title="role.title" style="min-width: 150px;white-space: break-spaces;"
                     :description="role.description">
        </a-card-meta>
        <a-button type="primary" style="margin-top:10px;" @click="setPermission(role)">设置权限</a-button>

      </a-card>
    </a-card>
    <!--    模态框-->
    <a-modal v-model="visible" title="配置权限" ok-text="确认" cancel-text="取消" @cancel="onCancel"
             @ok="onSubmit">
      <a-tree checkable :multiple="true" @check="onCheck"
              :expanded-keys="expandedKeys" :auto-expand-parent="autoExpandParent"
              :checkedKeys="checkedKeys" :tree-data="permissions" @expand="onExpand"/>
    </a-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      rid: null,
      roles: [],
      permissions: this.formatPermissions(this.$store.state.menus),//本地存储的权限
      disabled: false,
      visible: false,
      //    treeData相关
      expandedKeys: [],
      autoExpandParent: true,
      checkedKeys: [],
      replaceFields: {
        children: 'children',
        title: 'name',
        key: 'name'
      },
      subPermissions: [],
      roleHasPermissions: [],//[name...]
      defaultCheckedKeys: []
    }
  },
  created() {
    this.getRoles();
  },
  methods: {
    //初始化角色
    async initRoles() {
      await this.axios.post('admin/role/init').then(_ => {
        this.getRoles();
      })
    },
    //获取所有角色
    async getRoles() {
      await this.axios.get('admin/role').then(res => {
        this.roles = res;
        if (this.roles.length > 0) {
          this.disabled = true;
        }
      })
    },
    //格式化本地状态中的permissions
    formatPermissions(permissions) {
      //转换为{value:'',label:'',name:'',children:[]}格式
      let result = [];
      permissions.forEach(item => {
        let obj = {
          value: item.name,
          title: item.meta.title,
          key: item.name,
          children: []
        };
        if (item.children && item.children.length > 0) {
          obj.children = this.formatPermissions(item.children);
        }
        result.push(obj);
      });
      return result;
    },
    //去设置权限
    setPermission(role) {
      this.rid = role.id
      this.axios.post(`admin/role/${role.id}/permissions`).then(_ => {
        this.roleHasPermissions = _
        this.checkedKeys = _
        this.visible = true;
      })
      // this.defaultCheckedKeys=[]
      // this.defaultCheckedKeys=this.roleHasPermissions.map(item=>item.name)
    },


    //    点击checkbox事件
    onCheck(checkedKeys) {
      console.log('onCheck', checkedKeys);
      this.checkedKeys = checkedKeys;
      this.subPermissions = checkedKeys;
    },
    //    展开事件
    onExpand(expandedKeys) {
      // if not set autoExpandParent to false, if children expanded, parent can not collapse.
      // or, you can remove all expanded children keys.
      this.expandedKeys = expandedKeys;
      this.autoExpandParent = false;
    },
    //    关闭事件
    onCancel() {
      this.visible = false;
      this.roleHasPermissions = [];
      this.selectedKeys = []
    },
    //提交权限
    async onSubmit() {
      // console.log(this.subPermissions);
      await this.axios.post(`admin/role/${this.rid}/syncpermissions`, {permission: this.subPermissions}).then(_ => {
        this.visible = false;
      })
    },
  }
}
</script>

<style scoped>
</style>
