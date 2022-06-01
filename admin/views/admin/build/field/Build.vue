<template>
  <div>
    <a-card size="small">
      <a-form-model :model="formState"
                    ref="ruleForm"
                    :rules="rules">
        <a-row :gutter="[16,16]">
          <a-col :span="12">
            <a-form-model-item label="建筑面积">
              <a-input-number style="width:100%;" v-model="formState.building_area"/>
            </a-form-model-item>
            <a-form-model-item label="土地面积">
              <a-input-number style="width:100%;" :min="0" :step="0.01" v-model="formState.land_area"/>
            </a-form-model-item>
            <a-form-model-item label="建筑总面积">
              <a-input-number style="width:100%;" :min="0" :step="0.01" v-model="formState.total_area"/>
            </a-form-model-item>
            <a-form-model-item label="土地总面积">
              <a-input-number style="width:100%;" :min="0" v-model="formState.land_total_area"/>
            </a-form-model-item>
            <a-form-model-item label="土地性质">
              <a-select default-value="lucy" style="width: 120px" v-model="formState.land_nature">
                <a-select-option value="collective">
                  集体土地
                </a-select-option>
                <a-select-option value="state">
                  国有土地
                </a-select-option>

                <a-select-option value="transfer">
                  划拨土地
                </a-select-option>
                <a-select-option value="lease">
                  出让性质
                </a-select-option>
                <a-select-option value="other">
                  其他
                </a-select-option>
              </a-select>
            </a-form-model-item>
            <a-form-model-item label="项目主体单位名称">
              <a-input v-model="formState.project_unit_name"></a-input>
            </a-form-model-item>
            <a-form-model-item label="项目主体单位地址">
              <a-input v-model="formState.project_unit_address"></a-input>
            </a-form-model-item>
            <a-form-model-item label="项目主体单位法人">
              <a-input v-model="formState.project_unit_legal_person"></a-input>
            </a-form-model-item>

            <a-form-model-item label="项目主体单位联系电话">
              <a-input v-model="formState.project_unit_phone"></a-input>
            </a-form-model-item>

          </a-col>
          <a-col :span="12">
            <a-form-model-item label="项目主体单位是否灭失">
              <a-radio-group v-model="formState.project_unit_is_lost">
                <a-radio value="yes">
                  是
                </a-radio>
                <a-radio value="no" default>
                  否
                </a-radio>
              </a-radio-group>
            </a-form-model-item>
            <a-form-model-item label="灭失原因">
              <a-input type="textarea" v-model="formState.lost_reason"></a-input>
            </a-form-model-item>

            <!--            日期时间-->
            <a-form-model-item label="修建时间">
              <a-date-picker :locale="zhCN" value-format="YYYY-MM-DD" format="YYYY-MM-DD"
                             v-model="formState.build_time"/>
            </a-form-model-item>

            <a-form-model-item label="竣工时间">
              <a-date-picker
                  value-format="YYYY-MM-DD"
                  :locale="zhCN" format="YYYY-MM-DD"
                  v-model="formState.completion_time"/>
            </a-form-model-item>

            <!--            日期时间-->

            <a-form-model-item label="项目承建商名称">
              <a-input v-model="formState.project_builder_name"></a-input>
            </a-form-model-item>
            <a-form-model-item label="项目承建商地址">
              <a-input v-model="formState.project_builder_address"></a-input>
            </a-form-model-item>
            <a-form-model-item label="项目承建商法人">
              <a-input v-model="formState.project_builder_legal_person"></a-input>
            </a-form-model-item>
            <a-form-model-item label="项目承建商联系电话">
              <a-input v-model="formState.project_builder_phone"></a-input>
            </a-form-model-item>
            <a-form-model-item label="项目承建商是否灭失">
              <a-radio-group v-model="formState.project_builder_is_lost">
                <a-radio value="yes">
                  是
                </a-radio>
                <a-radio value="no">
                  否
                </a-radio>
              </a-radio-group>
            </a-form-model-item>
            <a-form-model-item label="项目承建商灭失原因">
              <a-input type="textarea" v-model="formState.project_builder_lost_reason"></a-input>
            </a-form-model-item>

          </a-col>
        </a-row>
        <a-row>
          <a-col>
            <a-form-model-item label="项目附加信息">
              <a-input type="textarea" :rows="4" v-model="formState.project_additional_information"></a-input>
            </a-form-model-item>
          </a-col>
        </a-row>
      </a-form-model>
    </a-card>
  </div>
</template>

<script>
import zhCN from 'ant-design-vue/lib/locale-provider/zh_CN';
import moment from "moment";

const rules = {
  name: [
    {required: true, message: '请输入楼盘名称', trigger: 'change'},
  ],
  project_name: [{required: true, message: '请输入项目名称', trigger: 'change'}],
}
export default {
  route: false,
  props: {
    formState: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      rules: rules,
      zhCN,
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
    moment,
    getCurrentData() {
      return new Date().toLocaleDateString();
    }
  }
}
</script>

<style scoped>

</style>
