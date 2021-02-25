<template>
    <div>
        <component v-bind:is="currentComponent" @submitSurvey="changeSurveyView" v-bind="currentProperties"></component>
    </div>
</template>

<script>
export default {
    name: "SurveyApp",
    data() {
        return {
            currentComponent: 'survey',
            responses: []
        }
    },
    methods: {
        changeSurveyView(responses) {
            this.currentComponent = 'survey-grader';
            this.responses = responses;
            confetti();
        }
    },
    computed: {
        currentProperties() {
            if (this.currentComponent === 'survey-grader') {
                return {responses: this.responses}
            }
        }
    }
}
</script>

<style scoped>

</style>
