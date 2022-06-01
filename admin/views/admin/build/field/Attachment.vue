<template>
  <div>
    <a-card size="small">
      <a-form-model :model="formState"
                    ref="ruleForm"
                    :rules="rules">
        <a-row :gutter="[16,16]">
          <a-col :span="12">
            <a-form-model-item label="项目批复文件" prop="project_approval_document">
              <UploadList
                  :images="formState.project_approval_document"
                  @changeImages="changeImages"
                  v-model="formState.project_approval_document"
                  fieldName="project_approval_document"
              />
            </a-form-model-item>
            <a-form-model-item label="土地批复文件" prop="land_approval_documents">
              <UploadList
                  :images="formState.land_approval_documents"
                  @changeImages="changeImages"
                  v-model="formState.land_approval_documents"
                  fieldName="land_approval_documents"
              />

            </a-form-model-item>
            <a-form-model-item label="规划建设许可证" prop="planning_construction_permits">
              <UploadList
                  :images="formState.planning_construction_permits"
                  @changeImages="changeImages"
                  v-model="formState.planning_construction_permits"
                  fieldName="planning_construction_permits"
              />

            </a-form-model-item>
            <a-form-model-item label="施工许可证" prop="construction_permit">
              <UploadList
                  :images="formState.construction_permit"
                  @changeImages="changeImages"
                  v-model="formState.construction_permit"
                  fieldName="construction_permit"
              />
            </a-form-model-item>
            <a-form-model-item label="消防验收报告" prop="fire_acceptance_report">
              <UploadList
                  :images="formState.fire_acceptance_report"
                  @changeImages="changeImages"
                  v-model="formState.fire_acceptance_report"
                  fieldName="fire_acceptance_report"
              />
            </a-form-model-item>
          </a-col>
          <a-col :span="12">
            <a-form-model-item label="联合验收报告" prop="joint_acceptance_report">
              <UploadList
                  :images="formState.joint_acceptance_report"
                  @changeImages="changeImages"
                  v-model="formState.joint_acceptance_report"
                  fieldName="joint_acceptance_report"
              />
            </a-form-model-item>

            <a-form-model-item label="施工图纸审批文件" prop="construction_drawing_examination_approval_documents">
              <UploadList
                  :images="formState.construction_drawing_examination_approval_documents"
                  @changeImages="changeImages"
                  v-model="formState.construction_drawing_examination_approval_documents"
                  fieldName="construction_drawing_examination_approval_documents"
              />
            </a-form-model-item>

            <a-form-model-item label="环保审核文件" prop="environmental_audit_file">
              <UploadList
                  :images="formState.environmental_audit_file"
                  @changeImages="changeImages"
                  v-model="formState.environmental_audit_file"
                  fieldName="environmental_audit_file"
              />
            </a-form-model-item>

            <a-form-model-item label="项目竣工图" prop="project_completion_figure">
              <UploadList
                  :images="formState.project_completion_figure"
                  @changeImages="changeImages"
                  v-model="formState.project_completion_figure"
                  fieldName="project_completion_figure"
              />
            </a-form-model-item>
          </a-col>
        </a-row>
      </a-form-model>
    </a-card>
  </div>
</template>

<script>
const rules = {
  name: [
    {required: true, message: '请输入楼盘名称', trigger: 'change'},
  ],
  project_name: [{required: true, message: '请输入项目名称', trigger: 'change'}],
  // project_address: [{required: true, message: '项目地址', trigger: 'change'}],
  // administrative_area: [{required: true, message: '行政管辖区域', trigger: 'change'}],
  // district_address: [
  //     {required: true, message: '区政府地址', trigger: 'change'},
  // ],
  // street_name: [{required: true, message: '街道办名称', trigger: 'change'}],
  // street_address: [{required: true, message: '街道办地址', trigger: 'change'}],
  // committee_name: [{required: true, message: '居委会名称', trigger: 'change'}],
  // committee_address: [{required: true, message: '居委会地址', trigger: 'change'}],
  // councilor: [{required: true, message: '居委会书记', trigger: 'change'}],
  // councilor_phone: [{required: true, message: '居委会联系电话', trigger: 'change'}],
}
import UploadList from '#/components/UploadList'

export default {
  route: false,
  props: {
    formState: {
      type: Object,
      required: true,
    }
  },
  components: {UploadList},
  data() {
    return {
      rules: rules
    }
  },
  mounted() {
    this.$scollTo('#build')
  },
  methods: {
    validate() {
      this.$refs.ruleForm.validate(valid => {
        if (valid) {
          this.$emit('isValidateHandle', true)

          return true
        } else {
          console.log('error submit!!');
          this.$emit('isValidateHandle', false)
          return false;
        }
      });
    },
    changeImages(images) {
      this.formState[images.fieldName] = images.images
    }
  }
}
</script>

<style scoped>

</style>
