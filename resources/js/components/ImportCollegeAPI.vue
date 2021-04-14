<template>
<div>
    <navbar></navbar>
    <div>
        <h1>Import degree information</h1>
        <p>To import degree information from your college's API, please provide the API URL, and match the applicable
            tags with ones from your college.</p>
        <label for="collegeApiUrl">College API URL: </label> <input type="text" id="collegeApiUrl" placeholder="API URL"
                                                                    v-model="apiURL">
        <div class="attributeBox rounded text-center fs-4 shadow-sm" v-for="tag in tableAttributes">
            <input type="checkbox" v-on:click="selectAttribute" :name="tag">
            Name: {{ tag }}
            <input type="text" :placeholder="tag">
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
        await this.fetchAttributes();
    },
    methods: {
        async fetchAttributes() {
            return axios.get('/api/degreetags').then(response => {
                this.tableAttributes = response.data;
            });
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
            axios({
                method: 'post', url: '/api/degreetags', data: {
                    submittedAttributes
                }
            }).then((response) => {
                console.log(response.data);
            }).catch(error => console.log(error));
        }
    },
    data() {
        return {
            tableAttributes: {},
            apiURL: "",
            selectedAttributes: []
        }
    }
}
</script>

<style scoped>
</style>
