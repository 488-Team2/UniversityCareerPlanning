<template>
    <div>
        <h1>Login</h1>
        <form @submit.prevent="handleLogin">
            <label>
                <input type="email" name="email" v-model="formData.email">
            </label>
            <label>
                <input type="password" name="password" v-model="formData.password">
            </label>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "login",
    data() {
        return {
            formData: {
                email: '',
                password: ''
            }
        }
    },
    methods: {
        handleLogin() {
            axios({
                method: "post",
                Accept: "application/json", //Make sure to set this in request, otherwise you will get weird redirect behavior from Laravel
                url: '/login',
                data: this.formData,
            }).then(response => {
                console.log(response.data);
            }).catch(error => console.log(error));
        }
    }
}
</script>

<style scoped>

</style>
