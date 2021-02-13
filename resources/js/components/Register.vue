<template>
    <div>
        <h1>Registration</h1>
        <form @submit.prevent="handleRegister">
            <label>Full name
                <input type="text" name="full_name" v-model="formData.full_name">
            </label>
            <label>Email address
                <input type="email" name="email" v-model="formData.email">
            </label>
            <label>Username
                <input type="text" name="username" v-model="formData.username">
            </label>
            <label>Password
                <input type="password" name="password" v-model="formData.password">
            </label>
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "Register",
    data() {
        return {
            formData: {
                full_name: '',
                email: '',
                username: '',
                password: ''
            }
        }
    },
    methods: {
        handleRegister() {
            axios({
                method: "post",
                Accept: "application/json",
                url: '/register',
                data: this.formData
            }).then(response => {
                console.log("we did it!");
            }).catch(error => console.log(error));
        }
    }
}
</script>

<style scoped>

</style>
