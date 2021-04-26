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
                                                                        v-model="apiURL" required>
            <div class="attributeBox rounded text-center fs-4 shadow-sm" v-for="tag in tableAttributes">
                <input type="checkbox" v-model="tag.isChecked" :name="tag.data_type">
                Name: {{ tag.data_type }}
                <input type="text" :placeholder="tag.data_type" v-model="tag.data_label">
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
        await this.fetchStoredAttributes();
        await this.fetchAttributes();
        this.setChecked();
    },
    methods: {
        async fetchAttributes() {
            return axios.get('/api/degreetags').then(response => {
                this.tableAttributes = response.data.map(item => {
                    let obj = {};
                    obj.data_type = item;
                    obj.isChecked = false;
                    return obj;
                });
            });
        },
        fetchStoredAttributes() {
            return axios.get('/api/degreeimportdata').then(data => {
                this.tableValues = data.data.data;
                console.log(this.tableValues[0].data_label);
                for (let i = 0; i < this.tableAttributes.length; i++) {
                    this.tableValues.forEach(function (item) {
                        if (this.tableAttributes[i].data_type === item.data_type) {
                            this.tableAttributes[i].data_label = item.data_label;
                            console.log("we did it");
                        }
                    });
                }
                this.apiURL = this.populatedValue("apiURL");
            });
        },
        populatedValue(attribute) {
            let found = false;
            console.log(attribute.data_type);
            for (let i = 0; i < this.tableValues.length && !found; i++) {
                if (this.tableValues[i].data_type === attribute.data_type && this.tableValues[i].data_label !== "") {
                    //console.log(this.tableValues[i].data_label);
                    found = true;
                    attribute.data_label = this.tableValues[i].data_label;
                }
            }
            return attribute.data_label;
        },
        setPopulatedValue(attribute, value) {
            let found = false;
            for (let i = 0; i < this.tableValues.length && !found; i++) {
                if (this.tableValues[i].data_type === attribute) {
                    console.log("Found!");
                    found = true;
                    this.tableValues[i].data_label = value;
                }
            }
        },
        selectAttributes() {
            let checkedAttributes = this.tableAttributes.filter(item => item.isChecked);
            checkedAttributes.forEach(item => {
                this.selectedAttributes.push(item);
            });
            /*if (event.target.checked) {
                this.selectedAttributes.push(event.target);
            } else {
                let itemIndex = this.selectedAttributes.indexOf(event.target);
                this.selectedAttributes.splice(itemIndex, 1);
            }*/
        },
        submitSelectedAttributes() {
            let submittedAttributes = [];
            this.selectAttributes();
            this.selectedAttributes.forEach((item) => {
                console.log(item.data_type);
                console.log(item.data_label);
                submittedAttributes.push({"itemName": item.data_type, "itemValue": item.data_label});
                this.setPopulatedValue(item.data_type, item.data_label);
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
        },
        setChecked() {
            for (let i = 0; i < this.tableValues.length; i++) {
                this.tableAttributes.forEach(item => {
                        if (item.data_type === this.tableValues[i].data_type) {
                            item.isChecked = !item.isChecked;
                            console.log("haha that tickles");
                            return item;
                        }
                    }
                );
            }
        }
        //TODO: write method for deleting field (Doug Doner 4/26/2021)

        //TODO: Setup button for importing data using selected fields (Doug Doner 4/26/2021)
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
