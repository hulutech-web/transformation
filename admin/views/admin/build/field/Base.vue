<template>
    <div>
        <a-card size="small">
            <a-form-model :model="formState"
                          ref="ruleForm"
                          :rules="rules">
                <a-row :gutter="[16,16]">
                    <a-col :span="12">
                        <a-form-model-item label="楼盘名称"  prop="name">
                            <a-input v-model="formState.name"/>
                        </a-form-model-item>
                        <a-form-model-item label="项目名称" prop="project_name">
                            <a-input v-model="formState.project_name"/>
                        </a-form-model-item>
                        <a-form-model-item label="项目地址" prop="project_address">
                            <a-input v-model="formState.project_address"/>
                        </a-form-model-item>
                        <a-form-model-item label="行政管辖区域" prop="administrative_area">
                            <a-select defaultValue="通川" style="width: 120px" v-model="formState.administrative_area">
                                <a-select-option value="通川">
                                    通川
                                </a-select-option>
                                <a-select-option value="达川">
                                    达川
                                </a-select-option>

                                <a-select-option value="高新">
                                    高新
                                </a-select-option>
                                <a-select-option value="宣汉">
                                    宣汉
                                </a-select-option>
                                <a-select-option value="开江">
                                    开江
                                </a-select-option>
                                <a-select-option value="万源">
                                    万源
                                </a-select-option>
                                <a-select-option value="大竹">
                                    大竹
                                </a-select-option>
                                <a-select-option value="渠县">
                                    渠县
                                </a-select-option>
                            </a-select>
                        </a-form-model-item>
                        <a-form-model-item label="区政府地址" prop="district_address">
                            <a-input v-model="formState.district_address"></a-input>
                        </a-form-model-item>
                    </a-col>
                    <a-col :span="12">
                        <a-form-model-item label="街道办名称" prop="street_name">
                            <a-input v-model="formState.street_name"></a-input>
                        </a-form-model-item>

                        <a-form-model-item label="街道办地址" prop="street_address">
                            <a-input v-model="formState.street_address"></a-input>
                        </a-form-model-item>

                        <a-form-model-item label="居委会名称" prop="committee_name">
                            <a-input v-model="formState.committee_name"></a-input>
                        </a-form-model-item>

                        <a-form-model-item label="居委会地址" prop="committee_address">
                            <a-input v-model="formState.committee_address"></a-input>
                        </a-form-model-item>

                        <a-form-model-item label="居委会书记" prop="councilor">
                            <a-input v-model="formState.councilor"></a-input>
                        </a-form-model-item>

                        <a-form-model-item label="居委会联系电话" prop="councilor_phone">
                            <a-input v-model="formState.councilor_phone"></a-input>
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
export default {
    route: false,
    props: {
        formState: {
            type: Object,
            required: true,
        }
    },
    data(){
        return {
            rules:rules
        }
    },
    mounted() {
        this.$scollTo('#build')
    },
    methods:{
        validate(){
            this.$refs.ruleForm.validate(valid => {
                if (valid) {
                    this.$emit('isValidateHandle',true)

                    return true
                } else {
                    console.log('error submit!!');
                    this.$emit('isValidateHandle',false)
                    return false;
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
