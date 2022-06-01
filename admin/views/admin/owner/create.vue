<template>
    <div>
        <a-card title="完整建档">
            <a-form-model ref="ruleForm" layout="horizontal" :model="form" :rules="rules">
                <a-row :gutter="[16,16]">
                    <a-col :span="8">
                        <a-form-model-item label="楼盘" prop="build_id">
                            <a-select v-model="form.build_id" style="width:100%;">
                                <a-select-option :value="build.id" v-for="(build,index) in builds" :key="index">
                                    {{ build.name }}
                                </a-select-option>
                            </a-select>
                        </a-form-model-item>
                    </a-col>
                    <a-col :span="8">
                        <a-form-model-item label="单元|栋|幢" prop="unit_id">
                            <a-select v-model="form.unit_id" style="width:100%;">
                                <a-select-option :value="unit.id" v-for="(unit,index) in units" :key="index">
                                    {{ unit.unit_name }}
                                </a-select-option>
                            </a-select>
                        </a-form-model-item>
                    </a-col>
                    <a-col :span="8">
                        <a-form-model-item ref="houseNumber" label="门牌号" prop="houseNumber">
                            <a-input type="text" v-model="form.houseNumber"></a-input>
                        </a-form-model-item>
                    </a-col>
                    <a-col :span="8">
                        <a-form-model-item label="户主名" prop="householder_name">
                            <a-input type="text" v-model="form.householder_name"></a-input>
                        </a-form-model-item>
                    </a-col>
                    <a-col :span="8">
                        <a-form-model-item label="性别" prop="householder_sex">
                            <a-radio-group v-model="form.householder_sex">
                                <a-radio value="male">男</a-radio>
                                <a-radio value="female">女</a-radio>
                            </a-radio-group>
                        </a-form-model-item>
                    </a-col>
                    <a-col :span="8">
                        <a-form-model-item label="身份证号" prop="householder_idNumber">
                            <a-input type="text" v-model="form.householder_idNumber"></a-input>
                        </a-form-model-item>
                    </a-col>
                    <a-col :span="8">
                        <a-form-model-item label="婚姻状况" prop="maritalStatus">
                            <a-select v-model="form.maritalStatus" style="width:100%;">
                                <a-select-option :value="m" v-for="(m,index) in maritalOptions" :key="index">
                                    {{ m }}
                                </a-select-option>
                            </a-select>
                        </a-form-model-item>
                    </a-col>
                    <a-col :span="8">
                        <a-form-model-item label="手机号" prop="householder_mobile">
                            <a-input type="text" v-model="form.householder_mobile"></a-input>
                        </a-form-model-item>
                    </a-col>
                </a-row>

                <!--            附件信息-->
                <a-row :gutter="16">
                    <a-col :span="16">
                        <a-form-model-item label="身份证复印件" prop="id_card_copy">
                            <UploadList
                                :images="form.id_card_copy"
                                @changeImages="changeImages"
                                v-model="form.id_card_copy"
                                fieldName="id_card_copy"
                            />
                        </a-form-model-item>
                    </a-col>
                </a-row>
                <a-row :gutter="16">
                    <a-col :span="16">
                        <a-form-model-item label="共有人身份证复印件" prop="mutual_person_id_photocopy">
                            <UploadList
                                :images="form.mutual_person_id_photocopy"
                                @changeImages="changeImages"
                                v-model="form.mutual_person_id_photocopy"
                                fieldName="mutual_person_id_photocopy"
                            />
                        </a-form-model-item>
                    </a-col>
                </a-row>
                <a-row :gutter="16">
                    <a-col :span="16">
                        <a-form-model-item label="婚育证明" prop="examination_prove">
                            <UploadList
                                :images="form.examination_prove"
                                @changeImages="changeImages"
                                v-model="form.examination_prove"
                                fieldName="examination_prove"
                            />
                        </a-form-model-item>
                    </a-col>
                </a-row>
                <a-row :gutter="16">
                    <a-col :span="16">
                        <a-form-model-item label="产权证来源证明" prop="source_property_right_card_to_prove">
                            <UploadList
                                :images="form.source_property_right_card_to_prove"
                                @changeImages="changeImages"
                                v-model="form.source_property_right_card_to_prove"
                                fieldName="source_property_right_card_to_prove"
                            />
                        </a-form-model-item>
                    </a-col>
                </a-row>
                <a-row :gutter="16">
                    <a-col :span="16">
                        <a-form-model-item label="新门牌号" prop="new_apartment">
                            <UploadList
                                :images="form.new_apartment"
                                @changeImages="changeImages"
                                v-model="form.new_apartment"
                                fieldName="new_apartment"
                            />
                        </a-form-model-item>
                    </a-col>
                </a-row>
                <a-row :gutter="16">
                    <a-col :span="16">
                        <a-form-model-item label="测绘报告" prop="report_surveying_mapp">
                            <UploadList
                                :images="form.report_surveying_mapp"
                                @changeImages="changeImages"
                                v-model="form.report_surveying_mapp"
                                fieldName="report_surveying_mapp"
                            />
                        </a-form-model-item>
                    </a-col>
                </a-row>
                <a-row :gutter="16">
                    <a-col :span="16">
                        <a-form-model-item label="唯一房查询报告" prop="only_room_query_report">
                            <UploadList
                                :images="form.only_room_query_report"
                                @changeImages="changeImages"
                                v-model="form.only_room_query_report"
                                fieldName="only_room_query_report"
                            />
                        </a-form-model-item>
                    </a-col>
                </a-row>
                <a-row :gutter="16">
                    <a-col :span="16">
                        <a-form-model-item label="户口簿" prop="residence_booklet">
                            <UploadList
                                :images="form.residence_booklet"
                                @changeImages="changeImages"
                                v-model="form.residence_booklet"
                                fieldName="residence_booklet"
                            />
                        </a-form-model-item>
                    </a-col>
                </a-row>
                <a-row :gutter="16">
                    <a-col :span="16">
                        <a-form-model-item label="购房交税发票" prop="purchase_tax_invoice">
                            <UploadList
                                :images="form.purchase_tax_invoice"
                                @changeImages="changeImages"
                                v-model="form.purchase_tax_invoice"
                                fieldName="purchase_tax_invoice"
                            />
                        </a-form-model-item>
                    </a-col>
                </a-row>
                <a-row :gutter="16">
                    <a-col :span="16">
                        <a-form-model-item label="契税票" prop="deed_tax_ticket">
                            <UploadList
                                :images="form.deed_tax_ticket"
                                @changeImages="changeImages"
                                v-model="form.deed_tax_ticket"
                                fieldName="deed_tax_ticket"
                            />
                        </a-form-model-item>
                    </a-col>
                </a-row>
                <!--            附件信息END-->

                <a-form-model-item style="display: block;">
                    <a-button type="primary" @click="onSubmit('ruleForm')">提交</a-button>
                </a-form-model-item>
            </a-form-model>
        </a-card>
    </div>
</template>

<script>
const ruleForm = {
    build_id: '',
    unit_id: '',
    houseNumber: '',
    householder_name: '',
    householder_idNumber: '',
    householder_sex: "",
    householder_mobile: '',
}
const rules = {
    build_id: [
        {
            required: true, message: '请填写身份证号', trigger: 'change',
            validator: (rule, value, callback) => {
                if (value == '' || value == undefined) {
                    callback(new Error('请选择楼盘'));
                }
                callback();
            }
        }],
    unit_id: [{
        required: true, message: '请选择单元', trigger: 'change',
        validator: (rule, value, callback) => {
            if (value == '' || value == undefined) {
                callback(new Error('请选择单元'));
            }
            callback();

        }
    }],
    houseNumber: [{
        required: true, message: '请输入门牌号', trigger: 'change',

        validator: (rule, value, callback) => {
            if (value == '' || value == undefined) {
                callback(new Error('请输入门牌号'));
            }
            callback();

        }
    }],
    maritalStatus:[
        {
            required: true, message: '请选择婚姻状况', trigger: 'change',

            validator: (rule, value, callback) => {
                if (value == '' || value == undefined) {
                    callback(new Error('请选择婚姻状况'));
                }
                callback();
            }
        }
    ],
    householder_name: [{
        required: true, message: '请输入户主', trigger: 'change',

        validator: (rule, value, callback) => {
            if (value == '' || value == undefined) {
                callback(new Error('请输入户主'));
            }
            callback();

        }
    }],
    householder_idNumber: [{
        required: true, message: '请输入身份证号', trigger: 'change',
        validator: (rule, value, callback) => {
            if (value == '' || value == undefined) {
                callback(new Error('请输入身份证号'));
            }
            //验证身份证
            if (!/^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/.test(value)) {
                callback(new Error('身份证号码不合法'));
            }
            callback();
        }
    }],
    householder_sex: [
        {
            required: true, message: '请选择性别', trigger: 'change',

            validator: (rule, value, callback) => {
                if (value == '' || value == undefined) {
                    callback(new Error('请选择性别'));
                }
                callback();
            }
        }
    ],
    householder_mobile: [{
        required: true, message: '手机号码不合法', trigger: 'change',

        validator: (rule, value, callback) => {
            if (value == '' || value == undefined) {
                callback(new Error('手机号码不合法'));
            }
            //验证手机号
            if (!/^1[3456789]\d{9}$/.test(value)) {
                callback(new Error('手机号码不合法'));
            }
            callback();

        }
    }],
}
const maritalOptions = [
    '未婚', '已婚', '离异', '丧偶'
]
import UploadList from '#/components/UploadList'

export default {
    path: '/admin/owner/create',
    components: {UploadList},
    data() {
        return {
            owner: null,
            ruleForm,
            rules,
            builds: [],
            units: [],
            maritalOptions,
            form: {},

        }
    },
    watch: {
        'form.build_id'(n, o) {
            let build = this.builds.find(item => item.id == n)
            if (build) {
                this.units = build.units
            }
        }
    },
    beforeCreate() {
        this.form = this.$form.createForm(this);
    },
    created() {
        this.getBuilds()
    },
    methods: {
        changeImages(images) {
            this.form[images.fieldName] = images.images
        },
        async getBuilds() {
            this.builds = await this.axios.post("admin/build/list")
        },
        onSubmit() {
            this.$refs.ruleForm.validate(async valid => {
                if (valid) {
                    this.$emit('isValidateHandle', true)
                    await this.axios.post("admin/contract", this.formState)
                    //清空formState
                    this.formState = {}
                    this.formState = this.$options.data().formState
                    return true
                } else {
                    console.log('error submit!!');
                    this.$emit('isValidateHandle', false)
                    return false;
                }
            });
        },
    }
}
</script>

<style scoped>

</style>
