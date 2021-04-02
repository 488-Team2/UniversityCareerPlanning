import {mount, shallowMount} from '@vue/test-utils'
import flushPromises from 'flush-promises'
import Survey from "../components/Survey.vue";
import axios from "axios";


test('has question text', async () => {
    const wrapper = mount(Survey);
    const response = await axios.get('/api/survey/questions')
    expect(wrapper.vm.$data.questions[0].question_text).toEqual(response.data.data[0].question_text);
});

test('Should load question data into questions object', async () => {
    const wrapper = mount(Survey);
    await flushPromises();
    await wrapper.vm.fetchQuestions();
    console.log(wrapper.vm.$data.questions[0].question_text);
    expect(wrapper.vm.$data.questions.length).toBeGreaterThan(0);
});
