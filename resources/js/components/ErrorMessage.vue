<template>
<div>
    <div class="alert alert-danger" role="alert" v-for="e in this.errors">
        {{ e }}
    </div>
</div>
</template>

<script>
export default {
    name: "ErrorMessage",
    props: {
        errors: {
            type: Array
        }
    }
}
</script>

<style scoped>

</style>
