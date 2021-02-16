<template>
    <div>
        <error-message :errors="errors"></error-message>
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
            <label>Confirm Password
                <input type="password" name="confirm_password" v-model="formData.password_confirmation">
            </label>
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script>
import ErrorMessage from "./ErrorMessage";

export default {
    name: "Register",
    data() {
        return {
            formData: {
                full_name: '',
                email: '',
                username: '',
                password: '',
                password_confirmation: ''
            },
            errors: []
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
                console.log("response: " + response);
                console.log("we did it!");
            }).catch(error => this.handleErrors(error));
        },
        handleErrors(error) {
            Object.entries(error.response.data.errors).forEach(([key, value]) => {
                this.errors.push(value[0]);
            });
        }
    },
    components: {
        errorMessage: ErrorMessage

    }
}
</script>

<style scoped>

</style>
