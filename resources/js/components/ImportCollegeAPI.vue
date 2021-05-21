<template>
    <div>
        <navbar></navbar>
        <alert-message :alert-array="alerts" :alertType="alertType"></alert-message>
        <div>
            <h1>Import degree information</h1>
            <p>To import degree information from your college's API, please provide the API URL, and match the
                applicable
                tags with ones from your college.</p>
            <label for="collegeApiUrl">College API URL: </label> <input type="text" id="collegeApiUrl"
                                                                        placeholder="API URL"
                                                                        v-model="apiURL" required>
            <button v-on:click.preven="importDegreeInfo" class="btn btn-primary btn-center">Import</button>
            <div class="attributeBox rounded text-center fs-4 shadow-sm" v-for="tag in tableAttributes">
                <input type="checkbox" v-model="tag.isChecked" :name="tag.data_type">
                Name: {{ tag.data_type }}
                <input type="text" v-model="tag.data_label">
                <button class="btn btn-danger" v-on:click="deleteAttribute(tag)">Delete</button>
            </div>
            <button v-on:click.prevent="submitSelectedAttributes" class="btn btn-primary btn-center">Submit changes
            </button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ImportCollegeAPI",
    async created() {
        await this.fetchAttributes();
        await this.fetchStoredAttributes();
    },
    methods: {
        /**
         * Sends request to server for degree table attributes
         * then creates an array of attribute objects to be used
         * in the Vue component
         *
         * @returns {Promise<void>}
         */
        async fetchAttributes() {
            return axios.get('/api/degreetags').then(response => {
                this.tableAttributes = response.data.map(item => {
                    let obj = {};
                    obj.data_type = item;
                    obj.isChecked = false;
                    obj.data_label = "";
                    return obj;
                });
            });
        },
        /**
         * Makes a request to the server for stored attribute labels
         * Stored attributes are then displayed in the input fields
         *
         * @returns {Promise<void>}
         */
        fetchStoredAttributes() {
            let self = this;
            return axios.get('/api/degreeimportdata').then(data => {
                let storedAttributes = data.data.data;
                for (let i = 0; i < this.tableAttributes.length; i++) {
                    storedAttributes.forEach(function (item) {
                        if (self.tableAttributes[i].data_type === item.data_type) {
                            self.tableAttributes[i].data_label = item.data_label;
                            self.tableAttributes[i].isChecked = true;
                        }
                    });
                }
                this.apiURL = storedAttributes.filter(item => item.data_type === "apiURL")[0].data_label;
            });
        },
        /**
         * Filters the attribute array for items that are checked
         * Array is used to send to the server to update stored
         * attributes
         *
         */
        selectAttributes() {
            let checkedAttributes = this.tableAttributes.filter(item => item.isChecked);
            checkedAttributes.forEach(item => {
                this.selectedAttributes.push(item);
            });
        },
        /**
         * Sends a delete request to the server with the stored attribute as a parameter
         * Then clears the input field for the deleted attribute
         *
         * If a server error occurs the error is passed to this.handleErrors
         *
         * @param tag
         */
        deleteAttribute(tag) {
            axios({
                method: 'delete', url: '/api/degreeimportdata', data: {
                    "itemName": tag.data_type
                }
            }).then(() => {
                tag.data_label = "";
                tag.isChecked = false;
                this.alerts = [];
                this.alerts.push('Degree item deleted');
                this.alertType = "alert-success";
            }).catch(error => this.handleErrors(error));
        },
        /**
         * Sends attribute changes to the server
         * Any errors are handled by handleErrors method
         */
        submitSelectedAttributes() {
            let submittedAttributes = [];
            this.selectAttributes();
            this.selectedAttributes.forEach((item) => {
                submittedAttributes.push({"itemName": item.data_type, "itemValue": item.data_label});
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
        /**
         * Helper method for displaying errors in the alert sub-component
         *
         * @param error
         */
        handleErrors(error) {
            this.alerts = [];
            Object.entries(error.response.data.errors).forEach(([, value]) => {
                this.alertType = "alert-danger";
                this.alerts.push(value[0]);
            });
        },
        /**
         * Method for initiating a degree import request
         * Uses selected attributes to map the API
         *
         * @returns {Promise<void>}
         */
        importDegreeInfo() {
            return axios.post('/api/degrees/import').then(() => {
                this.alerts = [];
                this.alerts.push('Degree import successful');
                this.alertType = "alert-success";
            }).catch(error => this.handleErrors(error));
        }
    },
    data() {
        return {
            tableAttributes: [],
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
