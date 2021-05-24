import { shallowMount } from '@vue/test-utils'
import adminDashboard from "../components/AdminDashboard.vue"
import axios from "axios";



describe("adminDashboard component unit tests: ", () => {
    let wrapper;

    beforeEach( async () => {
        wrapper = shallowMount(adminDashboard);
    })
    it('is a Vue instance', () => {
        expect(wrapper.vm).toBeTruthy();
    })
   /* it('Find input- type texts from adminDashboard', () => {
        expect(wrapper.contains('[data-test="userNameText"]')).toBe(true)
        expect(wrapper.contains('[data-test="userEmailText"]')).toBe(true)
        expect(wrapper.contains('[data-test="userDeptIdText"]')).toBe(true)
        expect(wrapper.contains('[data-test="userRoleText"]')).toBe(true)
        expect(wrapper.contains('[data-test="userAccountTypeText"]')).toBe(true)
        expect(wrapper.contains('[data-test="userSearchText"]')).toBe(true)
    })

    it('Calls axios', async () => {
       // const response = await axios.get('/api/users?page=1');
       await wrapper.vm.getListUsers(1)
       const listItems = wrapper.findAll("li");
       expect(listItems).toHaveLength(3);
        
    });*/


})