<template>
    <div>
        <div class="attributeBox border border-primary rounded text-center fs-4 shadow-sm" v-for="tag in tableAttributes" v-on:click="selectAttribute">{{tag}}</div>
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
        selectAttribute() {
        }
    },
    data() {
        return {
            tableAttributes: {}
        }
    }
}
</script>

<style scoped>
</style>
