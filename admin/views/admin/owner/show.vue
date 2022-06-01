<template>
    <div>
        <template>
            <div>
                <a-descriptions
                    title="业主详情"
                    bordered
                    :column="{ xxl: 4, xl: 3, lg: 3, md: 3, sm: 2, xs: 1 }"
                >
                    <a-descriptions-item label="楼盘名称">
                        {{ owner.build_name[0] }}
                    </a-descriptions-item>
                    <a-descriptions-item label="单元">
                        {{ owner.unit_id }}
                    </a-descriptions-item>
                    <a-descriptions-item label="门牌号">
                        {{ owner.houseNumber }}
                    </a-descriptions-item>
                    <a-descriptions-item label="户主名称">
                        {{ owner.householder_name }}
                    </a-descriptions-item>
                    <a-descriptions-item label="性别">
                        {{ owner.householder_sex }}
                    </a-descriptions-item>
                    <a-descriptions-item label="户主身份证号">
                        {{ owner.householder_idNumber }}
                    </a-descriptions-item>
                    <a-descriptions-item label="户主电话">
                        {{ owner.householder_mobile }}
                    </a-descriptions-item>
                    <a-descriptions-item label="婚姻状况">
                        {{ owner.maritalStatus }}
                    </a-descriptions-item>

                    <a-descriptions-item label="身份证复印件" :span="6">
                        <img :src="img" alt="" style="width:150px;height:150px;margin:10px;"
                             v-for="(img,index) in owner.id_card_copy" :key="index">
                    </a-descriptions-item>
                    <a-descriptions-item label="共有人身份证复印件" :span="6">
                        <img :src="img" alt="" style="width:150px;height:150px;margin:10px;"
                             v-for="(img,index) in owner.mutual_person_id_photocopy" :key="index">
                    </a-descriptions-item>
                    <a-descriptions-item label="婚育证明" :span="6">
                        <img :src="img" alt="" style="width:150px;height:150px;margin:10px;"
                             v-for="(img,index) in owner.examination_prove" :key="index">
                    </a-descriptions-item>
                    <a-descriptions-item label="产权证来源证明" :span="6">
                        <img :src="img" alt="" style="width:150px;height:150px;margin:10px;"
                             v-for="(img,index) in owner.source_property_right_card_to_prove" :key="index">
                    </a-descriptions-item>
                    <a-descriptions-item label="新门牌号" :span="6">
                        <img :src="img" alt="" style="width:150px;height:150px;margin:10px;"
                             v-for="(img,index) in owner.new_apartment" :key="index">
                    </a-descriptions-item>
                    <a-descriptions-item label="测绘报告" :span="6">
                        <img :src="img" alt="" style="width:150px;height:150px;margin:10px;"
                             v-for="(img,index) in owner.report_surveying_mapp" :key="index">
                    </a-descriptions-item>
                    <a-descriptions-item label="唯一房查询报告" :span="6">
                        <img :src="img" alt="" style="width:150px;height:150px;margin:10px;"
                             v-for="(img,index) in owner.only_room_query_report" :key="index">
                    </a-descriptions-item>
                    <a-descriptions-item label="户口簿" :span="6">
                        <img :src="img" alt="" style="width:150px;height:150px;margin:10px;"
                             v-for="(img,index) in owner.residence_booklet" :key="index">
                    </a-descriptions-item>
                    <a-descriptions-item label="购房交税发票" :span="6">
                        <img :src="img" alt="" style="width:150px;height:150px;margin:10px;"
                             v-for="(img,index) in owner.purchase_tax_invoice" :key="index">
                    </a-descriptions-item>
                    <a-descriptions-item label="契税票" :span="6">
                        <img :src="img" alt="" style="width:150px;height:150px;margin:10px;"
                             v-for="(img,index) in owner.deed_tax_ticket" :key="index">
                    </a-descriptions-item>

                </a-descriptions>
            </div>
        </template>

    </div>
</template>

<script>
import UploadList from '#/components/UploadList'

export default {
    path: `/admin/owner/:id/show`,
    components: {UploadList},
    data() {
        return {
            id: this.$route.params.id,
            owner: {},
            user: JSON.parse(localStorage.getItem('user'))
        }
    },
    created() {
        this.getOwner()
        // let id = this.$watermark.set(this.user.name + '-' + this.user.mobile.substr(7), this.$refs.content)
      // //离开当前页面时，删除水印
      // this.$router.beforeEach((to, from, next) => {
      //     this.$watermark.remove(id)
      //     next()
      // })
    },
    methods: {
        async getOwner() {
            this.owner = await this.axios.get(`admin/owner/${this.id}`)
        }
    }
}
</script>

<style scoped>

</style>
