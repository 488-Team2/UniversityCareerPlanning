<template>
    <div>
        <h2>Your career survey results</h2>
        <ul>
            <li v-for="degree in this.degreeOptions">
                {{ degree.degree_name }} - {{ degree.degree_description }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "surveyResults",
    props: {
        responses: Object
    },
    data() {
        return {
            topLetters: Object,
            degreeOptions: Array
        }
    },
    created() {
        this.gradeSurvey();
    },
    methods: {
        gradeSurvey() {
            this.topLetters = Object.fromEntries(Object.entries(this.responses).sort(([, a], [, b]) => b - a).slice(0, 3));
            console.log(this.topLetters);
            this.showDegreeOptions();
        },
        showDegreeOptions() {
            let self = this;
            let degreeUrl = "/api/degrees/codes/";
            for (let topLettersKey in this.topLetters) {
                degreeUrl += topLettersKey + " ";
            }

            axios.get(degreeUrl)
                .then(function (response) {
                    self.degreeOptions = response.data.data;
                });
        }
    }
}
</script>

<style scoped>

</style>
