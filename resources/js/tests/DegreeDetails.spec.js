import {shallowMount} from '@vue/test-utils'
import DegreeDetails from "../components/DegreeDetails.vue";
import axios from "axios"; 

test('expect prop prev_page_url and prop degree_id are required', function() {
    expect(DegreeDetails.props.prev_page_url.required).toBe(true)
    expect(DegreeDetails.props.degree_id.required).toBe(true)
     
});

test('fetchDegree populates degree object', async() => {
    const wrapper = shallowMount(DegreeDetails, {
        propsData: {
            prev_page_url: "test",
            degree_id: "999"
        }
    })
    await wrapper.vm.fetchDegree();
    const response = await axios.get('api/degree/999');

    expect(wrapper.vm.degree.degree_name).toEqual(response.data.data.degree_name);
    expect(wrapper.vm.degree.degree_description).toEqual(response.data.data.degree_description);
    expect(wrapper.vm.degree.department_id).toEqual(response.data.data.department_id);
    expect(wrapper.vm.degree.graduation_rate).toEqual(response.data.data.graduation_rate);
    expect(wrapper.vm.degree.job_prospects).toEqual(response.data.data.job_prospects);
    
});

test('fetchDegree invalid id', async() => {
    const wrapper = shallowMount(DegreeDetails, {
        propsData: {
            prev_page_url: "test",
            degree_id: "abc"
        }
    })
    await wrapper.vm.fetchDegree(); 
});
