<template>
  <div>
    <a-card :title="steps[current].content">
      <div>
        <a-steps :current="current">
          <a-step v-for="item in steps" :key="item.title" :title="item.title"/>
        </a-steps>
        <div class="steps-action">
          <a-button v-if="current < steps.length - 1" type="primary" @click="next">
            下一页
          </a-button>
          <a-button
              v-if="current == steps.length - 1"
              type="primary"
              @click="onSubmit"
          >
            <a-icon type="check-circle"/>
            完成
          </a-button>
          <a-button v-if="current > 0" style="margin-left: 8px" @click="prev">
            返回上一页
          </a-button>
        </div>
        <div class="steps-content">
          <component ref="componentForm" @isValidateHandle="isValidateHandle" v-bind:is="componentName"
                     :formState="formState"></component>
        </div>
        <div class="steps-action">
          <a-button v-if="current < steps.length - 1" type="primary" @click="next">
            下一页
          </a-button>
          <a-button
              v-if="current == steps.length - 1"
              type="primary"
              @click="onSubmit"
          >
            <a-icon type="check-circle"/>
            完成
          </a-button>
          <a-button v-if="current > 0" style="margin-left: 8px" @click="prev">
            返回上一页
          </a-button>
        </div>
      </div>
    </a-card>
  </div>
</template>

<script>
import Base from './field/Base.vue'
import Property from "./field/Property";
import Build from "./field/Build";
import Attachment from "./field/Attachment";

const formState = {
  name: null,
  project_name: null,
  project_address: null,
  administrative_area: null,
  district_address: null,
  street_name: null,
  street_address: null,
  committee_name: null,
  committee_address: null,
  councilor: null,
  councilor_phone: null,
  property_company_name: null,
  property_company_address: null,
  property_company_legal_person: null,
  property_company_phone: null,
  property_company_contact: null,
  property_company_contact_phone: null,
  owner_committee_name: null,
  owner_committee_address: null,
  owner_committee_chairman: null,
  owner_committee_phone: null,
  owner_committee_contact: null,
  owner_committee_contact_phone: null,
  project_introducer: null,
  project_introducer_phone: null,
  project_introducer_id_card: null,
  house_type: null,
  households_num: null,
  commercials_num: null,
  warehouses_num: null,
  parking_num: null,
  building_area: null,
  land_area: null,
  total_area: null,
  land_total_area: null,
  land_nature: null,
  project_unit_name: null,
  project_unit_address: null,
  project_unit_legal_person: null,
  project_unit_phone: null,
  project_unit_is_lost: null,
  build_time: null,
  completion_time: null,
  lost_reason: null,
  project_builder_name: null,
  project_builder_address: null,
  project_builder_legal_person: null,
  project_builder_phone: null,
  project_builder_is_lost: null,
  project_builder_lost_reason: null,
  project_additional_information: null,
  project_approval_document: null,
  land_approval_documents: null,
  planning_construction_permits: null,
  construction_permit: null,
  fire_acceptance_report: null,
  joint_acceptance_report: null,
  construction_drawing_examination_approval_documents: null,
  environmental_audit_file: null,
  project_completion_figure: null,
  deleted_at: null,
}
export default {
  components: {Base, Property, Build, Attachment},
  data() {
    return {
      current: 0,
      formState: formState,
      componentName: 'Base',
      steps: [
        {
          title: '第一步',
          content: '楼盘基础信息',
        },
        {
          title: '第二步',
          content: '物业信息',
        },
        {
          title: '第三步',
          content: '建筑信息',
        },
        {
          title: '第四步',
          content: '所需材料'
        }

      ],
      isValidate: false,
      user: JSON.parse(localStorage.getItem('user'))
    };
  },
  created() {
    //手机号后4位
    // let id = this.$watermark.set(this.user.name + '-' + this.user.mobile.substr(7), this.$refs.content)
    // //离开当前页面时，删除水印
    // this.$router.beforeEach((to, from, next) => {
    //   this.$watermark.remove(id)
    //   next()
    // })
  },

  watch: {
    current(n) {
      switch (n) {
        case 0:
          return this.componentName = 'Base';
        case 1:
          return this.componentName = 'Property';
        case 2:
          return this.componentName = 'Build';
        case 3:
          return this.componentName = 'Attachment';
      }
    }
  },
  methods: {
    next() {
      //提交子组件中的验证
      this.$refs.componentForm.validate()
      setTimeout(() => {
        if (this.isValidate) {
          this.current++;
        } else {
          this.$message.error('请检查错误')
        }
      }, 200)


      //每点击下一步，将formState缓存
      // localStorage.setItem('buidingForm',JSON.stringify(this.formState))
    },
    prev() {
      this.current--;
    },
    isValidateHandle(val) {
      this.isValidate = val
    },
    onSubmit() {
      //格式化日期

      this.axios.post(`admin/build`, this.formState).then(_ => {
        this.$router.push({name: 'admin.build.index'})
        this.formState = this.$options.data().formState
      })

    }
  },
};
</script>
<style scoped>
.steps-content {
  border-radius: 6px;
  background-color: #fafafa;
  min-height: 200px;
  padding-top: 10px;
}

.steps-action {
  margin-top: 24px;
}
</style>
