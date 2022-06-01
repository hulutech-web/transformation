<template>
    <div>
        <router-view/>
    </div>
</template>

<script>
export default {
    route:false,
    meta:{
        title: 'Transition',
        icon: 'mdi-transit-connection-variant',
        breadcrumb: [
            {title: 'Home', url: {name: 'home'}},
            {title: 'Transition'}
        ]
    },
}
</script>

<style scoped>

</style>
