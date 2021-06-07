<template>
    <div>
        <component v-bind:is="currentComponent" @submitSurvey="changeSurveyView" @beginSurvey="beginSurveyQuiz" v-bind="currentProperties"></component>
    </div>
</template>

<script>
export default {
    name: "SurveyApp",
    data() {
        return {
            currentComponent: 'survey-start',
            responses: []
        }
    },
    methods: {
        changeSurveyView(responses) {
            this.currentComponent = 'survey-results';
            this.responses = responses;
            confetti();
        },
        beginSurveyQuiz() {
            this.currentComponent = 'survey';
        }
    },
    computed: {
        currentProperties() {
            if (this.currentComponent === 'survey-results') {
                return {responses: this.responses}
            }
        }
    }
}
</script>

<style scoped>

</style>
