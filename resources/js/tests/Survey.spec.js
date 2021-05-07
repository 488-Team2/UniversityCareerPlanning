import {shallowMount} from '@vue/test-utils'
import flushPromises from 'flush-promises'
import Survey from "../components/Survey.vue";
import axios from "axios";

test('uses mounts', async () => {
    shallowMount(Survey);
});

test('has question text', async () => {
    const wrapper = shallowMount(Survey);
    const response = await axios.get('/api/survey/questions');
    await flushPromises();
    expect(wrapper.vm.$data.questions[0].question_text).toEqual(response.data.data[0].question_text);
    console.log(response.data.data[0].question_text);
});
