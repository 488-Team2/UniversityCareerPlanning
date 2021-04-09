<template>
    <div>
        <h2>Your career survey results</h2>
        <p>Based on your responses to the questions in the survey, we recommend the following degree paths. You can
            click
            on each degree option to find out more information about them.</p>
        <ul>
            <li v-for="degree in this.degreeOptions">
                <a v-bind:href="'/degree/'+degree.id" target="_blank">{{ degree.degree_name }}</a>
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
