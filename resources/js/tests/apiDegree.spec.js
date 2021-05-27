import {mount} from '@vue/test-utils'
import apiDegree from "../components/apiDegree.vue"
import axios from "axios"
import Vue from "vue";
import flushPromises from "flush-promises";
import {jest, test} from "@jest/globals";


test('renders a vue instance',  () => {
    const wrapper = mount(apiDegree)
    expect(wrapper.vm).toBeTruthy()
});

test('Find input- type texts',  () => {
    const  wrapper = mount(apiDegree)
    expect(wrapper.contains('[data-test="degreeNameText"]')).toBe(true)
    expect(wrapper.contains('[data-test="degreeDescriptionText"]')).toBe(true)
    expect(wrapper.contains('[data-test="degreeDeptIDText"]')).toBe(true)
    expect(wrapper.contains('[data-test="degreeRateText"]')).toBe(true)
    expect(wrapper.contains('[data-test="degreeJobText"]')).toBe(true)
});

test('has action buttons',  () => {
    const  wrapper = mount(apiDegree)
    expect(wrapper.contains('[data-test="btnCreate"]')).toBe(true)
    expect(wrapper.contains('[data-test="btnBack"]')).toBe(true)
    expect(wrapper.contains('[data-test="btnEdit"]')).toBe(true)
    expect(wrapper.contains('[data-test="btnDelete"]')).toBe(true)
    expect(wrapper.contains('[data-test="btnSave"]')).toBe(true)
    expect(wrapper.contains('[data-test="btnCancel"]')).toBe(true)
});

test('fetch getListDegrees', async() => {
    const wrapper = mount(apiDegree);
    await wrapper.vm.getListDegrees();
    const response = await axios.get('api/degreeDisplay?page=1');
    expect(wrapper.vm.listDegrees.data).toHaveLength(response.data.data.length);
});

test('get the correct list of degrees', async () => {
    const wrapper = mount(apiDegree);
    await wrapper.vm.getListDegrees();
    const response = await axios.get('api/degreeDisplay?page=1');

    expect(wrapper.vm.listDegrees.data[0].degree_name).toEqual(response.data.data[0].degree_name)
});

test('get the correct list of degrees', async () => {
    const wrapper = mount(apiDegree);
    await wrapper.vm.getListDegrees();
    const response = await axios.get('api/degreeDisplay?page=1');

    expect(wrapper.vm.listDegrees.data[0].degree_name).toEqual(response.data.data[0].degree_name)
});

test('clicking create button triggers createDegree()', async () => {
    const createDegreeMethodSpy = jest.spyOn(apiDegree.methods, 'createDegree')
    const wrapper = mount(apiDegree)
    expect(wrapper.find('[data-test="btnCreate"]').exists()).toBe(true)
    const addBtn = wrapper.find('[data-test="btnCreate"]')
    await addBtn.trigger('click')
    expect(createDegreeMethodSpy).toHaveBeenCalledTimes(1)
    createDegreeMethodSpy.mockReset();
});

