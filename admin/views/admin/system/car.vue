<template>
  <div>
    <a-card title="系統字段">
      <a-form>
        <a-form-model-item :label="field.title" v-for="(field,index) in fields" :key="index">
          <a-radio-group v-model="form[field.name]">
            <a-radio v-for="(option,index) in options" :key="index">
              {{ option }}
            </a-radio>
          </a-radio-group>
        </a-form-model-item>
        <a-form-model-item>
          <a-button type="primary" @click="onSubmit">
            提交
          </a-button>
        </a-form-model-item>
      </a-form>
    </a-card>
  </div>
</template>

<script>
const fields = [
  {name: 'BrakeFluid', title: '剎車油', options: ['正常', '更換', '建議更換']},
  {name: 'Cooking_oil', title: '軚油', options: ['正常', '更換', '建議更換']},
  {name: 'OBD', title: 'OBDII電腦', options: ['正常', '更換', '建議更換']},
  {name: 'CheckEngine', title: '檢查引擎', options: ['正常', '更換', '建議更換']},
  {name: 'StartupCondition', title: '車輛啟動狀況', options: ['正常', '更換', '建議更換']},
  {name: 'AllInstrumentsElectric', title: '全車儀錶及電器設施', options: ['正常', '更換', '建議更換']},
  {name: 'ColdAirSystem', title: '冷氣系統', options: ['正常', '更換', '建議更換']},
  {name: 'ParkingSystem', title: '駐車系統', options: ['正常', '更換', '建議更換']},
  {name: 'BrakingSystem', title: '制動系統', options: ['正常', '更換', '建議更換']},
  {name: 'ClutchSystem', title: '離合器系統', options: ['正常', '更換', '建議更換']},
  {name: 'SuspensionSystem', title: '懸掛系統', options: ['正常', '更換', '建議更換']},
  {name: 'SteeringSystem', title: '轉向系統', options: ['正常', '更換', '建議更換']},
  {name: 'ChassisSituation', title: '底盤狀況', options: ['正常', '更換', '建議更換']},
  {name: 'EmphasisHasBeenPlacedOnFrontBelt', title: '調校車頭皮帶', options: ['正常', '更換', '建議更換']},
  {name: 'AllActivitiesHingePreview', title: '全車活動鉸位打油', options: ['正常', '更換', '建議更換']},
  {name: 'AdditionalFacilities', title: '附加設備', options: ['正常', '更換', '建議更換']},
  {name: 'VehicleTailBucket', title: '車輛尾斗等', options: ['正常', '更換', '建議更換']},
]
const options = [
  '正常', '更換', '建議更換'
]
export default {
  data() {
    return {
      form: {fields: fields},
      fields: fields,
      options
    }
  },
  methods: {
    async onSubmit() {
      await this.axios.post('admin/caritem/fieldinit', this.form)
    }
  }
}
</script>

<style scoped>
</style>