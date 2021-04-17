import {mount} from '@vue/test-utils'
import SurveyApp from "../components/SurveyApp.vue";
import Survey from "../components/Survey.vue";
import axios from "axios";
import SurveyResults from "../components/SurveyResults.vue";
import SurveyStart from "../components/SurveyStart.vue";
import {test} from "@jest/globals";

test('has question text', async () => {
    const surveyWrapper = mount(Survey);
    const response = await axios.get('/api/survey/questions')
    expect(surveyWrapper.vm.$data.questions[0].question_text).toEqual(response.data.data[0].question_text);
});

test('Should load question data into questions object', async () => {
    const surveyWrapper = mount(Survey);
    await surveyWrapper.vm.fetchQuestions();
    expect(surveyWrapper.vm.$data.questions.length).toBeGreaterThan(0);
});

test('Advances survey when user clicks response and selects next question button', async () => {
    const surveyWrapper = mount(Survey);
    expect(surveyWrapper.exists()).toBe(true);
    await surveyWrapper.vm.fetchQuestions();
    const currentIndex = surveyWrapper.vm.$data.currentQuestionIndex;
    let answerInput = surveyWrapper.find('input[type=radio]');
    let nextQuestionButton = surveyWrapper.find('.btn');

    await answerInput.trigger('change');
    await nextQuestionButton.trigger('click');
    expect(surveyWrapper.vm.$data.currentQuestionIndex).toBeGreaterThan(currentIndex);
});

test('Button stays disabled when answer is not selected', async () => {
    const surveyWrapper = mount(Survey);
    await surveyWrapper.vm.fetchQuestions();
    const currentIndex = surveyWrapper.vm.$data.currentQuestionIndex;
    let nextQuestionButton = surveyWrapper.find('.btn');

    await nextQuestionButton.trigger('click');
    expect(surveyWrapper.vm.$data.currentQuestionIndex).toEqual(currentIndex);
    expect(surveyWrapper.vm.$data.currentQuestion.question_text).toEqual(surveyWrapper.vm.$data.questions[0].question_text);
});

test('Displays career survey results after answering all questions', async () => {
    const wrapper = mount(SurveyApp, {components: {SurveyStart, Survey, SurveyResults}});
    const surveyStartWrapper = wrapper.findComponent(SurveyStart);
    await surveyStartWrapper.find('button').trigger('click');
    const surveyWrapper = wrapper.findComponent(Survey);
    expect(surveyWrapper.exists()).toBe(true);
    await surveyWrapper.vm.fetchQuestions();
    const initialQuestionIndex = surveyWrapper.vm.$data.currentQuestionIndex;
    let answerInput = surveyWrapper.find('input[type=radio]');
    let nextQuestionButton = surveyWrapper.find('.btn');

    for (let i = 0; i < 42; i++) {
        await answerInput.trigger('change');
        await nextQuestionButton.trigger('click');
    }

    console.log(surveyWrapper.vm.$data.currentQuestionIndex);
    expect(surveyWrapper.vm.$data.currentQuestionIndex).toEqual(41);
    expect(surveyWrapper.vm.$data.currentQuestionIndex).toBeGreaterThan(initialQuestionIndex);
    //const resultsWrapper = wrapper.findComponent(SurveyResults);
});

test('Loads SurveyStart child component', async () => {
    const wrapper = mount(SurveyApp, {components: {SurveyStart, Survey}});
    const surveyStartWrapper = wrapper.findComponent(SurveyStart);
    expect(surveyStartWrapper.exists()).toBe(true);
});
