<template>
    <div>
        <div :class="alertType" class='alert' role="alert" v-for="alertItem in alertArray">
            {{ alertItem }}
        </div>
    </div>
</template>

<script>
export default {
    name: "alert-message",
    props: {
        alertArray: Array
    }
}
</script>

<style scoped>

</style>
