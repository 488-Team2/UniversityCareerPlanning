<template>
    <div>
        <alert :alert-array="alerts" :alertType="alertType"></alert>
        <h2 :class="currentQuestion.question_code">Question: {{ currentQuestion.question_text }}</h2>
        <div class="answer-inputs">
            <div>
                <label>
                    <input v-model="selectedAnswer" name="answer" type="radio"
                           value="yes">
                    Yes
                </label>
            </div>
            <div>
                <label>
                    <input v-model="selectedAnswer" name="answer" type="radio"
                           value="no">
                    No
                </label>
            </div>
        </div>

        <p>Current question: {{ currentQuestionIndex + 1 }} / {{ questions.length }}</p>
        <button class="btn btn-primary" v-on:click="goToNextQuestion" :disabled="isDisabled">{{ buttonText }}</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Survey",
    data() {
        return {
            questions: Array,
            currentQuestion: {},
            currentQuestionIndex: 0,
            selectedAnswer: null,
            responses: [],
            alerts: [],
            alertType: "",
            responseArray: {"R": 0, "I": 0, "A": 0, "S": 0, "E": 0, "C": 0}
        }
    },
    async created() {
        await this.fetchQuestions();
    },
    methods: {
        goToNextQuestion() {
            if (this.questions.length > 0 && this.currentQuestionIndex !== this.questions.length - 1) {
                if (this.selectedAnswer === "yes")
                    this.responseArray[this.currentQuestion.question_code]++;

                this.responses.push(this.selectedAnswer);
                this.currentQuestion = this.questions[++this.currentQuestionIndex];
                this.selectedAnswer = null;
            } else {
                //Send responses to parent component so they can be graded
                this.$emit('submitSurvey', this.responseArray);
            }
        },
        fetchQuestions() {
            return axios.get('/api/survey/questions').then(response => {
                this.questions = response.data.data;
                this.currentQuestion = this.questions[0];
                return response;
            });
        }
    },
    computed: {
        isDisabled() {
            return this.selectedAnswer === null;
        },
        buttonText() {
            if (this.currentQuestionIndex < this.questions.length - 1) {
                return "Next question";
            } else {
                return "Complete survey";
            }
        }
    }
}
</script>

<style scoped>

</style>
