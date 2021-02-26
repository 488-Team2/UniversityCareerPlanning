<template>
    <div>
        <h2>Your career survey results</h2>
        <ul>
            <li v-for="(score, letter) in topLetters">
                {{ letter }} - {{ score }}
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
            topLetters: Object
        }
    },
    created() {
        this.gradeSurvey();
    },
    methods: {
        gradeSurvey() {
            this.topLetters = Object.fromEntries(Object.entries(this.responses).sort(([, a], [, b]) => b - a).slice(0, 3));
        }
    }
}
</script>

<style scoped>

</style>
