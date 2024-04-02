<template>
    <router-view name="home"></router-view>
    <Toast />
</template>

<script>
import Toast from "primevue/toast";
export default {
    components:{
        Toast
    }
}
</script>

<style lang="scss">
@import url('@public/scss/main.scss');
</style>
