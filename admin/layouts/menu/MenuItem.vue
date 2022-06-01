<template>
    <div>
        <a-sub-menu >
            <template #title>
                <a-icon :type="menuInfo.icon" />
                <span>{{ menuInfo.title }}</span>
            </template>
            <template v-for="item of menuInfo.children">
                <template v-if="!item.children">
                    <a-menu-item  @click="navigate(item)">
                        <a-icon :type="item.icon" />
                        {{ item.title }}
                    </a-menu-item>
                </template>

                <template v-else>
                    <MenuItem :menuInfo="item" />
                </template>
            </template>
        </a-sub-menu>
    </div>
</template>

<script>
export default {
    props: ["menuInfo"],
    methods:{
        navigate(item){
            this.$router.push({name:item.name})
        }
    }
};
</script>

<style lang="scss" scoped></style>
