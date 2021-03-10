import {mount} from '@vue/test-utils'
import Survey from "../components/Survey";

test('uses mounts', () => {
    const wrapper = mount(Survey);
    expect(wrapper).toMatchSnapshot();
});

test('has question text', () => {
    const wrapper = mount(Survey);

});
