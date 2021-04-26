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
        <button class="btn btn-primary" @click="addSessionSurvey(result)" > Save To Session </button>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "surveyResults",
    props: {
        responses: Object
    },
    data() {
        return {
            topLetters: Object,
            degreeOptions: Array,

            count: '0',
            surveySessions: []
            
        }
    },
    created() {
        this.gradeSurvey();
        this.viewSurveySession();
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
        },
        viewSurveySession() {
            if(localStorage.getItem('surveySessions')) {
                this.surveySessions = JSON.parse(localStorage.getItem('surveySessions'));
                this.count = this.surveySessions.length;
            }
        },
        addSessionSurvey(result) {
            
            this.surveySessions = [...this.degreeOptions ];
            this.storeSession();
            alert('Result saved!');

        },
        storeSession() {
             let parsed = JSON.stringify(this.surveySessions);
             localStorage.setItem('surveySessions', parsed);
             this.viewSurveySession();
        }, 
        removeSession(res) {
            this.surveySessions.splice(res, 1);
            this.storeSession();
        } 
    }
}

</script>

<style scoped>

</style>