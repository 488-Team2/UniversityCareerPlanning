<template>
    <div>
        <error-message :alert-array="alerts" :alertType="alertType"></error-message>
        <div class="row">
            <div class="col-sm-8">
                <h1>Registration</h1>
                <form @submit.prevent="handleRegister">
                    <div class="mb-3">
                        <label>Full name
                        </label>
                        <input type="text" class="form-control" name="full_name" v-model="formData.full_name"
                               placeholder="full name">
                    </div>
                    <div class="mb-3">
                        <label>Email address
                        </label>
                        <input type="email" class="form-control" placeholder="Email address" name="email"
                               v-model="formData.email">
                    </div>
                    <div class="mb-3">
                        <label>Username
                        </label>
                        <input type="text" class="form-control" placeholder="Username" name="username"
                               v-model="formData.username">
                    </div>
                    <div class="mb-3">
                        <label>Password
                        </label>
                        <input type="password" class="form-control" placeholder="Password" name="password"
                               v-model="formData.password">
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password
                        </label>
                        <input type="password" class="form-control" placeholder="Confirm password"
                               name="confirm_password"
                               v-model="formData.password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import ErrorMessage from "./Alert";

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
            alerts: [],
            alertType: ""
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
                if (response.status === 201) {
                    this.alerts = [];
                    this.alerts.push('Registration successful');
                    this.alertType = "alert-success";
                }
            }).catch(error => this.handleErrors(error));
        },
        handleErrors(error) {
            this.alerts = [];
            if (error.response.data.errors != null) {
                Object.entries(error.response.data.errors).forEach(([key, value]) => {
                    this.alertType = "alert-danger";
                    this.alerts.push(value[0]);
                });
            }
        }
    },
    components: {
        errorMessage: ErrorMessage

    }
}
</script>

<style scoped>

</style>
