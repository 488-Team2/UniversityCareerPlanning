<template>
    <div>
        <p v-for="tag in tags">{{tag}}</p>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "ImportCollegeAPI",
    async created() {
        await this.fetchTags();
    },
    methods: {
        async fetchTags() {
            return axios.get('/api/degreetags').then(response => {
                this.tags = response.data;
            });
        }
    },
    data() {
        return {
            tags: {}
        }
    }
}
</script>

<style scoped>

</style>
