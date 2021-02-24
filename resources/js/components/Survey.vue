<template>
    <div>
        <alert :alert-array="alerts" :alertType="alertType"></alert>
        <h2>{{ currentQuestion.question_text }}</h2>
        <div v-for="answer in currentQuestion.career_survey_answers">
            <label :for="answer.answer_text">
                <input v-model="selectedAnswer" name="answer" type="radio"
                       :value="answer.answer_text">
                {{ answer.answer_text }}
            </label>
        </div>

        <p>Current question: {{ this.currentQuestionIndex + 1 }}</p>
        <button v-on:click="goToNextQuestion" :disabled="isDisabled">{{ buttonText }}</button>
    </div>
</template>

<script>
export default {
    name: "Survey",
    data() {
        return {
            questions: Array,
            currentQuestion: Object,
            currentQuestionIndex: 0,
            selectedAnswer: null,
            responses: [],
            alerts: [],
            alertType: ""
        }
    },
    created() {
        this.fetchQuestions();
    },
    methods: {
        fetchQuestions() {
            let self = this;
            axios({
                method: "get",
                Accept: "application/json",
                url: 'api/survey/questions',
            }).then(function (response) {
                self.questions = response.data.data;
                self.currentQuestion = self.questions[0];
            }).catch(error => console.log(error));
        },
        goToNextQuestion() {
            if (this.questions.length > 0 && this.currentQuestionIndex !== this.questions.length - 1) {
                this.responses.push(this.selectedAnswer);
                this.currentQuestion = this.questions[++this.currentQuestionIndex];
                this.selectedAnswer = null;
            } else {
                this.sendQuestionResponses();
            }
        },
        sendQuestionResponses() {
            let self = this;
            axios({
                method: "post",
                Accept: "application/json",
                url: 'api/survey',
                data: this.responses
            }).then(function (response) {
                if (response.status === 201) {
                    this.alerts = [];
                    this.alerts.push('Successfully submitted career survey!');
                    this.alertType = "alert-success";
                }
            }).catch(error => console.log(error));
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
