<template>
    <div>
        <a-card>
            <a-card style="margin-top:2px;" title="快速建档">
                <template #extra>
                    <a-button type="primary" @click="$router.push({path:'/admin/owner/create'})">
                        <a-icon type="plus"/>
                        完整建档
                    </a-button>
                </template>
                <a-form-model ref="ruleForm" layout="inline" :model="form" :rules="rules">
                    <a-form-model-item label="楼盘" prop="build_id">
                        <a-select v-model="form.build_id" style="width:200px;">
                            <a-select-option :value="build.id" v-for="(build,index) in builds" :key="index">
                                {{ build.name }}
                            </a-select-option>
                        </a-select>
                    </a-form-model-item>
                    <a-form-model-item label="单元|栋|幢" prop="unit_id">
                        <a-select v-model="form.unit_id" style="width:200px;">
                            <a-select-option :value="unit.id" v-for="(unit,index) in units" :key="index">
                                {{ unit.unit_name }}
                            </a-select-option>
                        </a-select>
                    </a-form-model-item>
                    <a-form-model-item label="门牌号" prop="houseNumber">
                        <a-input type="text" v-model="form.houseNumber"></a-input>
                    </a-form-model-item>
                    <a-form-model-item label="户主名" prop="householder_name">
                        <a-input type="text" v-model="form.householder_name"></a-input>
                    </a-form-model-item>
                    <a-form-model-item label="性别" prop="householder_sex">
                        <a-radio-group v-model="form.householder_sex">
                            <a-radio value="male">男</a-radio>
                            <a-radio value="female">女</a-radio>
                        </a-radio-group>
                    </a-form-model-item>

                    <a-form-model-item label="身份证号" prop="householder_idNumber">
                        <a-input type="text" v-model="form.householder_idNumber"></a-input>
                    </a-form-model-item>
                    <a-form-model-item label="婚姻状况" prop="maritalStatus">
                        <a-select v-model="form.maritalStatus" style="width:200px;">
                            <a-select-option :value="m" v-for="(m,index) in maritalOptions" :key="index">
                                {{ m }}
                            </a-select-option>
                        </a-select>
                    </a-form-model-item>
                    <a-form-model-item label="手机号" prop="householder_mobile">
                        <a-input type="text" v-model="form.householder_mobile"></a-input>
                    </a-form-model-item>
                    <a-form-model-item style="display: block;">
                        <a-button type="primary" @click="onSubmit('ruleForm')">提交</a-button>
                    </a-form-model-item>
                </a-form-model>
            </a-card>


            <a-card title="住户列表" style="margin-top:12px;">
                <template #extra>
                    <div style="display: flex;">
                        <a-input-search placeholder="请输入户主名" v-model="keyword" enter-button="搜索" @search="onSearch"/>
                    </div>
                </template>
                <a-table :dataSource="dataSource" :columns="columns" bordered rowKey="id" :pagination="false">
                    <template slot="operation" slot-scope="text, record">
                        <a href="javascript:; "
                           @click="$router.push({path:`/admin/owner/${record.id}/edit`})">完整编辑</a>
                        <a href="javascript:; " @click="edit(record)">快捷编辑</a>
                        <a-popconfirm v-if="dataSource.length" title="确定删除吗?" @confirm="() => onDelete(record)">
                            <a href="javascript:;" style="color:red;">删除</a>
                        </a-popconfirm>
                    </template>
                    <template slot="showAction" slot-scope="text, record">
                        <a href="javascript:; "
                           @click="$router.push({path:`/admin/owner/${record.id}/show`})">查看</a>
                    </template>

                </a-table>
                <a-pagination v-if="tableData.total>tableData.per_page" :defaultCurrent='1' :total="tableData.total"
                              :pageSize="tableData.per_page"
                              @change="getOwners">
                </a-pagination>
                <!--        弹出-->

                <a-drawer
                    title="基础资料"
                    :width="720"
                    :visible="visible"
                    :body-style="{ paddingBottom: '80px' }"
                    @close="onClose"
                >

                    <a-form :form="formState" layout="vertical" hide-required-mark>
                        <a-row :gutter="16">
                            <a-col :span="8">
                                <a-form-item label="门牌">
                                    <a-input
                                        v-decorator="[
                  'houseNumber',
                  {
                    rules: [{ required: true, message: '门牌' }],
                  },
                ]"
                                        style="width: 100%"
                                        placeholder="请输入门牌"
                                    />
                                </a-form-item>

                            </a-col>
                            <a-col :span="8">
                                <a-form-item label="户主名">
                                    <a-input
                                        v-decorator="[
                  'householder_name',
                  {
                    rules: [{ required: true, message: '户主名' }],
                  },
                ]"
                                        style="width: 100%"
                                        placeholder="请输入户主名"
                                    />
                                </a-form-item>
                            </a-col>
                            <a-col :span="8">
                                <a-form-item label="性别">
                                    <a-radio-group v-decorator="[
                  'householder_sex',
                  {
                    rules: [{ required: true, message: '性别' }],
                  },
                ]"
                                                   style="width: 100%"
                                                   placeholder="性别">
                                        <a-radio value="male">男</a-radio>
                                        <a-radio value="female">女</a-radio>
                                    </a-radio-group>
                                </a-form-item>
                            </a-col>

                        </a-row>

                        <a-row :gutter="16">
                            <a-col :span="8">

                                <a-form-item label="身份证号">
                                    <a-input
                                        v-decorator="[
                  'householder_idNumber',
                  {
                    rules: [{ required: true, message: '身份证号' }],
                  },
                ]"
                                        style="width: 100%"
                                        placeholder="请输入身份证号"
                                    />
                                </a-form-item>
                            </a-col>
                            <a-col :span="8">
                                <a-form-item label="户主电话">
                                    <a-input-number
                                        :min="0"
                                        v-decorator="[
                  'householder_mobile',
                  {
                    rules: [{ required: true, message: '户主电话' }],
                  },
                ]"
                                        placeholder="请输入户主电话"
                                        style="width: 100%"
                                    />
                                </a-form-item>
                            </a-col>
                            <a-col :span="8">
                                <a-form-item label="婚姻状况" prop="maritalStatus">
                                    <a-select v-decorator="[
                                              'maritalStatus',
                                              {
                                                rules: [{ required: true, message: '婚姻状况' }],
                                              },
                                            ]"
                                              placeholder="请选择婚姻状况">
                                        <a-select-option
                                            style="width: 100%"
                                            :value="m" v-for="(m,index) in maritalOptions" :key="index">
                                            {{ m }}
                                        </a-select-option>
                                    </a-select>
                                </a-form-item>
                            </a-col>
                        </a-row>
                    </a-form>
                    <div
                        :style="{
          position: 'absolute',
          right: 0,
          bottom: 0,
          width: '100%',
          borderTop: '1px solid #e9e9e9',
          padding: '10px 16px',
          background: '#fff',
          textAlign: 'right',
          zIndex: 1,
        }"
                    >
                        <a-button type="primary" @click="onClose">
                            取消
                        </a-button>
                        <a-button type="primary" @click="handleSubmit">
                            提交
                        </a-button>
                    </div>
                </a-drawer>

                <!--        弹出end-->
            </a-card>
        </a-card>
    </div>
</template>

<script>
const columns = [
    {
        title: 'id',
        dataIndex: 'id',
        key: 'id'
    },
    {
        title: '楼盘',
        dataIndex: 'build_name',
        key: 'build_name'
    },
    {
        title: '单元|栋|幢',
        dataIndex: 'unit_id',
        key: 'unit_id'
    },
    {
        title: '门牌号',
        dataIndex: 'houseNumber',
        key: 'houseNumber'
    },

    {
        title: '户主名',
        dataIndex: 'householder_name',
        key: 'householder_name'
    },
    {
        title: '详情',
        dataIndex: 'showAction',
        key: 'showAction',
        scopedSlots: {customRender: 'showAction'},
    },
    {
        title: '操作',
        dataIndex: 'operation',
        key: 'operation',
        scopedSlots: {customRender: 'operation'},
    }

]
const eduOptions = [
    '小学', '初中', '高中', '大专', '大学本科', '研究生'
]
//未婚0、已婚1、离异2、丧偶3
const maritalOptions = [
    '未婚', '已婚', '离异', '丧偶'
]
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
    build_id: [{
        validator: (rule, value, callback) => {
            if (value == '' || value == undefined) {
                callback(new Error('请选择楼盘'));
            }
            callback();

        }, trigger: 'change'
    }],
    unit_id: [{
        validator: (rule, value, callback) => {
            if (value == '' || value == undefined) {
                callback(new Error('请选择单元'));
            }
            callback();

        }, trigger: 'change'
    }],
    houseNumber: [{
        validator: (rule, value, callback) => {
            if (value == '' || value == undefined) {
                callback(new Error('请输入门牌号'));
            }
            callback();

        }, trigger: 'change'
    }],
    householder_name: [{
        validator: (rule, value, callback) => {
            if (value == '' || value == undefined) {
                callback(new Error('请输入户主'));
            }
            callback();

        }, trigger: 'change'
    }],
    householder_idNumber: [{
        validator: (rule, value, callback) => {
            if (value == '' || value == undefined) {
                callback(new Error('请输入身份证号'));
            }
            //验证身份证
            if (!/^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/.test(value)) {
                callback(new Error('身份证号码不合法'));
            }
            callback();
        }, trigger: 'change'
    }],
    householder_sex: [
        {
            validator: (rule, value, callback) => {
                if (value == '' || value == undefined) {
                    callback(new Error('请选择性别'));
                }
                callback();
            }, trigger: 'change'
        }
    ],
    maritalStatus: [
        {
            validator: (rule, value, callback) => {
                if (value == '' || value == undefined) {
                    callback(new Error('请选择婚姻状况'));
                }
                callback();
            }, trigger: 'change'
        }
    ],
    householder_mobile: [{
        validator: (rule, value, callback) => {
            if (value == '' || value == undefined) {
                callback(new Error('请输入门手机号码'));
            }
            //验证手机号
            if (!/^1[3456789]\d{9}$/.test(value)) {
                callback(new Error('手机号码不合法'));
            }
            callback();

        }, trigger: 'change'
    }],
}

export default {
    data() {
        return {
            ruleForm,
            rules,
            form: {},
            units: [],
            dataSource: [],
            tableData: {},
            builds: [],
            columns,
            eduOptions,
            maritalOptions,
            owners: [],
            keyword: '',
            visible: false,
            method: 'post',
            unit_id: '',
            build_id: '',
            id: '',
        }
    },
    beforeCreate() {
        this.formState = this.$form.createForm(this);
    },
    created() {
        this.getOwners()
        this.getBuilds()
    },
    watch: {
        'form.build_id'(n, o) {
            let build = this.builds.find(item => item.id == n)
            if (build) {
                this.units = build.units
            }
        }
    },
    methods: {
        async onSearch() {
            this.tableData = await this.axios.post('admin/owner/searchOwner', {keyword: this.keyword})
            this.dataSource = this.tableData.data
        }
        ,
        async getBuilds() {
            this.builds = await this.axios.post("admin/build/list")
        },

        async onSubmit(formName) {
            this.$refs[formName].validate(async valid => {
                    if (valid) {
                        await this.axios.post(`admin/build/${this.form.build_id}/unit/${this.form.unit_id}/owner`, this.form).then(_ => {
                            this.form = this.$options.data().form
                            this.getOwners()
                        })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                }
            )
            ;
        },
        async getOwners(page = 1) {
            this.tableData = await this.axios.get(`admin/owner?page=${page}`)
            this.dataSource = this.tableData.data
        },

        async edit(record) {
            this.visible = true;
            this.build_id = record.build_id
            this.unit_id = record.unit_id
            this.id = record.id
            this.$nextTick(() => {
                this.formState.setFieldsValue({
                    houseNumber: record.houseNumber,
                    householder_name: record.householder_name,
                    householder_sex: record.householder_sex,
                    householder_idNumber: record.householder_idNumber,
                    householder_mobile: record.householder_mobile,
                    maritalStatus: record.maritalStatus
                });
                this.method = 'put';
            })
        },
        async onDelete(record) {
            this.axios.delete(`admin/build/${record.build_id}/unit/${record.unit_id}/owner/${record.id}`).then(_ => {
                this.getOwners()
            })
        },
        onClose() {
            this.visible = false
            this.formState.resetFields();
        },
        async handleSubmit() {
            this.formState.validateFields((err, values) => {
                if (!err) {
                    values = Object.assign(values, {build_id: this.build_id});
                    console.log(values);
                    this.method = 'put'
                    let url = `admin/build/${this.build_id}/unit/${this.unit_id}/owner/${this.id}`
                    this.axios[this.method](url, values).then(res => {
                        this.visible = false;
                        this.form = this.$form.createForm(this);
                        this.getOwners();
                    });
                }
            });
        },
        changeImages(images) {
            this.formState[images.fieldName] = images.images
        },
        addtion(record) {
            this.$router.push({path: `/admin/owner/${record.id}/addtion`})
        }
    }
}
</script>

<style scoped>
</style>
