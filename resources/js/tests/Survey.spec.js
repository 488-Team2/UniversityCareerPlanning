import {shallowMount} from '@vue/test-utils'
import flushPromises from 'flush-promises'
import Survey from "../components/Survey.vue";
import axios from "axios";

test('uses mounts', async () => {
    shallowMount(Survey);
});

test('has question text', () => {
    const wrapper = shallowMount(Survey);
    return axios.get('/api/survey/questions').then((response) => {
        expect(wrapper.vm.$data.questions[0].question_text).toEqual(response.data.data[0].question_text);
    });
});
