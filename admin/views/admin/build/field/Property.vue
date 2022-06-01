<template>
  <div>
    <a-card size="small">
      <a-form-model :model="formState"
                    ref="ruleForm"
                    :rules="rules">
        <a-row :gutter="[16,16]">
          <a-col :span="12">
            <a-form-model-item label="物业公司名称">
              <a-input v-model="formState.property_company_name"/>
            </a-form-model-item>
            <a-form-model-item label="物业公司地址">
              <a-input v-model="formState.property_company_address"/>
            </a-form-model-item>
            <a-form-model-item label="物业公司法人">
              <a-input v-model="formState.property_company_legal_person"/>
            </a-form-model-item>
            <a-form-model-item label="物业公司联系电话">
              <a-input v-model="formState.property_company_phone"/>
            </a-form-model-item>
            <a-form-model-item label="物业公司联系人">
              <a-input v-model="formState.property_company_contact"/>
            </a-form-model-item>
            <a-form-model-item label="物业公司联系人电话">
              <a-input v-model="formState.property_company_contact_phone"/>
            </a-form-model-item>


            <a-form-model-item label="业主委员会名称">
              <a-input v-model="formState.owner_committee_name"/>
            </a-form-model-item>
            <a-form-model-item label="业主委员会地址">
              <a-input v-model="formState.owner_committee_address"/>
            </a-form-model-item>
            <a-form-model-item label="业主委员会主任">
              <a-input v-model="formState.owner_committee_chairman"/>
            </a-form-model-item>
            <a-form-model-item label="业主委员会联系电话">
              <a-input v-model="formState.owner_committee_phone"/>
            </a-form-model-item>
            <a-form-model-item label="业主委员会联系人">
              <a-input v-model="formState.owner_committee_contact"/>
            </a-form-model-item>
            <a-form-model-item label="业主委员会联系人电话">
              <a-input v-model="formState.owner_committee_contact_phone"/>
            </a-form-model-item>
          </a-col>
          <a-col :span="12">
            <a-form-model-item label="项目介绍人">
              <a-input v-model="formState.project_introducer"/>
            </a-form-model-item>
            <a-form-model-item label="项目介绍人电话">
              <a-input v-model="formState.project_introducer_phone"/>
            </a-form-model-item>
            <a-form-model-item label="项目介绍人身份证号">
              <a-input v-model="formState.project_introducer_id_card"/>
            </a-form-model-item>

            <a-form-model-item label="房屋类型">
              <a-select default-value="commercial" style="width: 120px" v-model="formState.house_type">
                <a-select-option value="commercial">
                  商品房
                </a-select-option>
                <a-select-option value="resettlement">
                  安置房
                </a-select-option>

                <a-select-option value="union">
                  联建房
                </a-select-option>
                <a-select-option value="fundraising">
                  集资房
                </a-select-option>
                <a-select-option value="changesroom">
                  房改房
                </a-select-option>
                <a-select-option value="selfbuilt">
                  自建房
                </a-select-option>
                <a-select-option value="other">
                  其他
                </a-select-option>

              </a-select>
            </a-form-model-item>

            <a-form-model-item label="住宅数">
              <a-input-number style="width:100%;" :min="0" v-model="formState.households_num"></a-input-number>
            </a-form-model-item>

            <a-form-model-item label="商业数">
              <a-input-number style="width:100%;" :min="0" v-model="formState.commercials_num"></a-input-number>
            </a-form-model-item>

            <a-form-model-item label="仓库数">
              <a-input-number style="width:100%;" :min="0" v-model="formState.warehouses_num"></a-input-number>
            </a-form-model-item>

            <a-form-model-item label="停车位数">
              <a-input-number style="width:100%;" :min="0" v-model="formState.parking_num"></a-input-number>
            </a-form-model-item>


          </a-col>
        </a-row>
      </a-form-model>
    </a-card>
  </div>
</template>

<script>
const rules = {
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
export default {
  route: false,
  props: {
    formState: {
      type: Object,
      required: true
    },
    rules: rules
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
    }
  }
}
</script>

<style scoped>

</style>
