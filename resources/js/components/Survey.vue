<template>
    <div>
        <alert :alert-array="alerts" :alertType="alertType"></alert>
        <h2 :class="currentQuestion.question_code">{{ currentQuestion.question_text }}</h2>
        <div>
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
            currentQuestion: {},
            currentQuestionIndex: 0,
            selectedAnswer: null,
            responses: [],
            alerts: [],
            alertType: "",
            responseArray: {"R": 0, "I": 0, "A": 0, "S": 0, "E": 0, "C": 0}
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
                console.log(self.currentQuestion);
            }).catch(error => console.log(error));
        },
        goToNextQuestion() {
            if (this.questions.length > 0 && this.currentQuestionIndex !== this.questions.length - 1) {
                if (this.selectedAnswer === "yes")
                    this.responseArray[this.currentQuestion.question_code]++;

                this.responses.push(this.selectedAnswer);
                this.currentQuestion = this.questions[++this.currentQuestionIndex];
                this.selectedAnswer = null;
            } else {
                //Grade the responses and give a recommendation for the types of degrees
                this.alerts = [];
                this.alerts.push('Successfully submitted career survey!');
                this.alertType = "alert-success";
            }
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
