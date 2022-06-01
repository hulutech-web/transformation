<template>
  <div>
    <a-card :title="`设置角色,用户：${user.name}`">
      <a-form-model :model="form">
        <a-form-model-item label="可选角色">
          <a-radio-group v-model="form.role.id" :default-value="String(form.role.id)" size="large"
                         button-style="solid">
            <a-radio v-for="(role,index) in roles" :key="index" :value="role.id">
              {{ role.title }}:【{{ role.description }}】
            </a-radio>
            <a-radio :value="''">
              <span style="color:red;">清除角色</span>
            </a-radio>
          </a-radio-group>
        </a-form-model-item>
        <a-form-item>
          <a-button type="primary" @click="submit">提交</a-button>
        </a-form-item>
      </a-form-model>
    </a-card>
  </div>
</template>

<script>
export default {
  path: `/admin/user/:id/role`,
  meta: {permission: '修改用户角色'},
  data() {
    return {
      roles: [],
      form: {
        role: {}
      },
      user: {},
      plainOptions: [],
      uid: this.$route.params.id,
    }
  },
  created() {
    this.getUser()
    this.getRoles()
    this.getUserRole()
  },
  methods: {
    async getRoles() {
      this.roles = await this.axios.get('admin/role')
    },
    async getUser() {
      this.user = await this.axios.get(`admin/user/${this.uid}`)
    },
    async getUserRole() {
      let role = await this.axios.post(`admin/user/${this.uid}/role`)
      this.form.role = {
        id: role.id,
        name: role.name,
        title: role.title,
        description: role.description
      }
    },
    submit() {
      this.axios.post(`admin/user/${this.uid}/setRole`, [this.form.role.id])
      // this.$router.push({name: 'admin.user.index'})
    }
  }
}
</script>

<style scoped>
.offline, .normal, .abnormal {
  display: inline-block;
  margin: 0 10px;
}

.offline input[type=radio], .normal input[type=radio], .abnormal input[type=radio] {
  display: none;
}

.offline input[type="radio"] + span, .normal input[type="radio"] + span, .abnormal input[type="radio"] + span {
  vertical-align: middle;
  width: 24px;
  height: 24px;
  border: 1px gray solid;
  border-radius: 12px;
  display: inline-block;
  background-color: white;
}

.offline input[type="radio"]:checked + span {
  background-color: gray;
}

.normal input[type="radio"]:checked + span {
  border: 1px green solid;
  background-color: green;
}


.abnormal input[type=radio]:checked + span {
  background-color: red;
  border: 1px red solid;
}

.abnormal input[type=radio]:checked + span::before {
  color: #ffffff;
  padding-left: 3px;
  font-weight: bold;
  content: "×";
  font-size: 24px;
  line-height: 24px;
}

.normal input[type=radio]:checked + span::before {
  color: #ffffff;
  padding-left: 3px;
  font-weight: bold;
  content: "√";
  font-size: 24px;
  line-height: 24px;
}

.offline input[type=radio]:checked + span::before {
  color: #ffffff;
  padding-left: 0px;
  font-weight: bold;
  content: "／";
  font-size: 24px;
  line-height: 24px;
}
</style>
