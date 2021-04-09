<template>
    <div>
        <alert :alert-array="alerts" :alertType="alertType"></alert>
        <div class="row">
            <div class="col-sm-8">
                <h1>Registration</h1>
                <form @submit.prevent="handleRegister">
                    <div class="mb-3">
                        <label>Full name
                            <input type="text" class="form-control" name="full_name" v-model="formData.full_name"
                                   placeholder="full name">
                        </label>
                    </div>
                    <div class="mb-3">
                        <label>Email address
                        <input type="email" class="form-control" placeholder="Email address" name="email"
                               v-model="formData.email">
                        </label>
                    </div>
                    <div class="mb-3">
                        <label>Username
                            <input type="text" class="form-control" placeholder="Username" name="username"
                                   v-model="formData.username">
                        </label>
                    </div>
                    <div class="mb-3">
                        <label>Password
                            <input type="password" class="form-control" placeholder="Password" name="password"
                                   v-model="formData.password">
                        </label>
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password
                            <input type="password" class="form-control" placeholder="Confirm password"
                                   name="confirm_password"
                                   v-model="formData.password_confirmation">
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Alert from "./Alert";

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
            Object.entries(error.response.data.errors).forEach(([, value]) => {
                this.alertType = "alert-danger";
                this.alerts.push(value[0]);
            });
        }
    },
    components: {
        alertMessage: Alert

    }
}
</script>

<style scoped>

</style>
