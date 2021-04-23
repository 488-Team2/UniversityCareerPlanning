<template>
    <div>
        <navbar></navbar>
        <alert :alert-array="alerts" :alertType="alertType"></alert>
        <div>
            <h1>Import degree information</h1>
            <p>To import degree information from your college's API, please provide the API URL, and match the
                applicable
                tags with ones from your college.</p>
            <label for="collegeApiUrl">College API URL: </label> <input type="text" id="collegeApiUrl"
                                                                        placeholder="API URL"
                                                                        v-model="apiURL">
            <div class="attributeBox rounded text-center fs-4 shadow-sm" v-for="tag in tableAttributes">
                <input type="checkbox" v-on:click="selectAttribute" :name="tag">
                Name: {{ tag }}
                <input type="text" :placeholder="tag" v-bind:value="populatedValue(tag)">
            </div>
            <button v-on:click="submitSelectedAttributes" class="btn btn-primary btn-center">Submit changes</button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ImportCollegeAPI",
    async created() {
        await this.fetchStoredAttributes();
        await this.fetchAttributes();
    },
    methods: {
        async fetchAttributes() {
            return axios.get('/api/degreetags').then(response => {
                this.tableAttributes = response.data;
            });
        },
        fetchStoredAttributes() {
            return axios.get('/api/degreeimportdata').then(data => {
                this.tableValues = data.data.data;
            });
        },
        populatedValue(attribute) {
            let found = false;
            let value = "";
            for(let i = 0; i < this.tableValues.length && !found; i++) {
                if(this.tableValues[i].data_type === attribute) {
                    found = true;
                    value = this.tableValues[i].data_label;
                }
            }
            return value;
        },
        selectAttribute(event) {
            if (event.target.checked) {
                this.selectedAttributes.push(event.target);
            } else {
                let itemIndex = this.selectedAttributes.indexOf(event.target);
                this.selectedAttributes.splice(itemIndex, 1);
            }
        },
        submitSelectedAttributes() {
            let submittedAttributes = [];
            this.selectedAttributes.forEach((item) => {
                submittedAttributes.push({"itemName": item.name, "itemValue": item.nextElementSibling.value});
            });
            submittedAttributes.push({"itemName": "apiURL", "itemValue": this.apiURL});
            axios({
                method: 'post', url: '/api/degreetags', data: {
                    submittedAttributes
                }
            }).then(() => {
                this.alerts = [];
                this.alerts.push('Degree info updated');
                this.alertType = "alert-success";
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
    data() {
        return {
            tableAttributes: [],
            tableValues: [],
            apiURL: "",
            selectedAttributes: [],
            alertType: '',
            alerts: []
        }
    }
}
</script>

<style scoped>
</style>
