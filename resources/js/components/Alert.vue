<template>
    <div>
        <div :class="alertType" class='alert' role="alert" v-for="alert in this.alertArray">
            {{ alert }}
        </div>
    </div>
</template>

<script>
export default {
    name: "ErrorMessage",
    props: {
        alertArray: Array,
        alertType: String
    }
}
</script>

<style scoped>

</style>
