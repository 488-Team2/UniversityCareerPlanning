<template>
    <div>
        <h1>Career Survey</h1>
        <p>Welcome to the career survey. This survey will ask a series of questions, and your responses to those questions
            will help us to recommend some potential degree options. When you have finished answering the questions,
            click on 'complete survey' and the quiz will grade your
            responses, and recommend degree offerings that may be a good fit for you.</p>
        <div class="text-center">
            <button class="btn btn-primary" v-on:click="beginSurvey">Begin career survey</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "SurveyStart",
    methods: {
        beginSurvey() {
            this.$emit('beginSurvey');
        }
    }
}
</script>

<style scoped>
.h1{
    font-size:60px;
    text-align:center;
}
</style>
