<template>
    <div>
        <div :class="alertType" class='alert' role="alert" v-for="alert in alertArray">
            {{ alert }}
        </div>
    </div>
</template>

<script>
export default {
    name: "alert-message",
    props: {
        alertArray: Array,
        alertType: String
    }
}
</script>

<style scoped>

</style>
