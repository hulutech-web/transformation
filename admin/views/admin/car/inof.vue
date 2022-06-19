<template>
  <div>
    <a-card title="新建資料">
      <template #extra>
        <a-button type="link" @click="customerShow">客戶列表</a-button>
      </template>
      <a-form-model ref="ruleForm" :model="form" :rules="rules">
        <a-form-model-item label="客戶名稱" prop="company_name">
          <a-input v-model="form.company_name"></a-input>
        </a-form-model-item>
        <a-form-model-item label="車牌號碼" prop="car_number">
          <a-input v-model="form.car_number"></a-input>
        </a-form-model-item>
        <a-form-model-item label="品牌" prop="car_brand">
          <a-input v-model="form.car_brand"></a-input>
        </a-form-model-item>
        <a-form-model-item label="型號" prop="car_type">
          <a-input v-model="form.car_type"></a-input>
        </a-form-model-item>
        <a-form-model-item>
          <a-button type="primary" @click="onSubmit">
            添加
          </a-button>
        </a-form-model-item>
      </a-form-model>
    </a-card>

  </div>
</template>

<script>

const rules = {
  company_name: [
    {required: true, message: '請輸入公司名稱', trigger: 'blur'},
  ],
  car_number: [{required: true, message: '請輸入車牌號', trigger: 'blur'}],
  car_brand: [{required: true, message: '請輸入汽車品牌', trigger: 'blur'}],
  car_type: [
    {
      required: true,
      message: '請輸入汽車型號',
      trigger: 'blur',
    },
  ]
}
export default {
  path: "/admin/car/info",
  data() {
    return {
      rules,
      form: {},
    }
  },
  watch: {
    'form.car_number'(val) {
      if (val) {
        this.form.car_number = val.toUpperCase()
      }
    },
    'form.car_brand'(val) {
      if (val) {
        this.form.car_brand = val.toUpperCase()
      }
    },
    'form.car_type'(val) {
      if (val) {
        this.form.car_type = val.toUpperCase()
      }
    }
  },
  methods: {
    customerShow() {
      this.$router.push({path: '/admin/car/customer'})
    },
    onSubmit() {
      this.$refs.ruleForm.validate(async valid => {
        if (valid) {
          await this.axios.post('admin/carinfo', this.form)
          this.$refs.ruleForm.resetFields();
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    }
  }
}
</script>

<style scoped>

</style>