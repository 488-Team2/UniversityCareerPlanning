import { mount } from '@vue/test-utils'
import adminDashboard from "../components/adminDashboard.vue"
import axios from "axios"
import Vue from "vue";
import {jest, test} from "@jest/globals";



test('renders a vue instance',  () => {
    const wrapper = mount(adminDashboard)
    expect(wrapper.vm).toBeTruthy()
});

test('Find input texts',  () => {
    const  wrapper = mount(adminDashboard)
    expect(wrapper.contains('[data-test="userNameText"]')).toBe(true)
    expect(wrapper.contains('[data-test="userEmailText"]')).toBe(true)
    expect(wrapper.contains('[data-test="userDeptIdText"]')).toBe(true)
    expect(wrapper.contains('[data-test="userRoleText"]')).toBe(true)
    expect(wrapper.contains('[data-test="userSearchText"]')).toBe(true)
});

test('fetch getListUsere', async() => {
    const wrapper = mount(adminDashboard);
    await wrapper.vm.getListUsers();
    const response = await axios.get('api/users');
    expect(wrapper.vm.list_users.data).toHaveLength(response.data.data.length);
});
/*
describe("adminDashboard component unit tests: ", () => {
    let wrapper;

    beforeEach( async () => {
        wrapper = shallowMount(adminDashboard);
    })
    it('is a Vue instance', () => {
        expect(wrapper.vm).toBeTruthy();
    })
    it('Find input- type texts from adminDashboard', () => {
        expect(wrapper.contains('[data-test="userNameText"]')).toBe(true)
        expect(wrapper.contains('[data-test="userEmailText"]')).toBe(true)
        expect(wrapper.contains('[data-test="userDeptIdText"]')).toBe(true)
        expect(wrapper.contains('[data-test="userRoleText"]')).toBe(true)
        expect(wrapper.contains('[data-test="userAccountTypeText"]')).toBe(true)
        expect(wrapper.contains('[data-test="userSearchText"]')).toBe(true)
    })

    test('fetch getUserList', async() => {
        const wrapper = mount(apiDegree);
        await wrapper.vm.getListUsers();
        const response = await axios.get('/api/users');
        expect(wrapper.vm.list_users.data).toHaveLength(response.data.data.length);
    });


})*/