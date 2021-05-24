import { shallowMount } from '@vue/test-utils'
import apiDegree from "../components/apiDegree.vue"
import axios from "axios";
import flushPromises from 'flush-promises'


jest.mock('axios', () => {
    return {
        get:  jest.fn(() => Promise.resolve({ 
          data: { 
              degree: [{
                id: 1, 
                name: 'Computer Science', 
                description: 'This is description for CS major',
                department_id: '1',
                graduation_rate: 80,
                job_demand: 90 
             },
             {
                id: 2,
                name: 'Computer Science2', 
                description: 'This is description for CS2 major',
                department_id: '1',
                graduation_rate: 70,
                job_demand: 60 
              }]
    }}))

    }
})

describe("apiDegree.vue", () => {
    let wrapper;

    beforeEach( async () => {
        wrapper = shallowMount(apiDegree)
        jest.resetModules()
        jest.clearAllMocks()
    })

    it('renders a vue instance', () => {
        //expect(shallowMount(apiDegree).isVueInstance()).toBe(true);
        expect(wrapper.vm).toBeTruthy();
    })
    it('Find input- type texts ', () => {
        expect(wrapper.contains('[data-test="degreeNameText"]')).toBe(true)
        expect(wrapper.contains('[data-test="degreeDescriptionText"]')).toBe(true)
        expect(wrapper.contains('[data-test="degreeDeptIDText"]')).toBe(true)
        expect(wrapper.contains('[data-test="degreeRateText"]')).toBe(true)
        expect(wrapper.contains('[data-test="degreeJobText"]')).toBe(true)
    })

    it('has action buttons', () => {
        expect(wrapper.contains('[data-test="btnCreate"]')).toBe(true)
        expect(wrapper.contains('[data-test="btnBack"]')).toBe(true)
       // expect(wrapper.contains('[data-test="btnEdit"]')).toBe(false)
       // expect(wrapper.contains('[data-test="btnDelete"]')).toBe(false)
        //expect(wrapper.contains('[data-test="btnSave"]')).toBe(false)
       // expect(wrapper.contains('[data-test="btnCancel"]')).toBe(false)
    })

    test('Click create button and clear input', async () =>{
        wrapper.find('[data-test="btnCreate"]').trigger("click");

        var textInput = wrapper.find('[data-test="degreeNameText"]')
        expect(textInput.text()).toMatch('')
        expect(wrapper.vm.degree.degree_name).toBe('')


        var textInput1 = wrapper.find('[data-test="degreeDescriptionText"]')
        expect(textInput1.text()).toMatch('')
        expect(wrapper.vm.degree.degree_description).toBe('')

        var textInput2 = wrapper.find('[data-test="degreeDeptIDText"]')
        expect(textInput2.text()).toMatch('')
        expect(wrapper.vm.degree.department_id).toBe('')

        var textInput3 = wrapper.find('[data-test="degreeRateText"]')
        expect(textInput3.text()).toMatch('')
        expect(wrapper.vm.degree.graduation_rate).toEqual(0)

        var textInput4 = wrapper.find('[data-test="degreeJobText"]')
        expect(textInput4.text()).toMatch('')
        expect(wrapper.vm.degree.job_demand).toEqual(0)

      }) 

      it("Calls axios.get and get list of degrees", async () => {
          
        wrapper.vm.getListDegrees()
        const response = await axios.get('/api/degreeDisplay')
        //console.log(wrapper.vm.listDegrees.data.length)
        console.log(wrapper.vm.listDegrees)
        console.log(response.data.data.data.length)
        expect(wrapper.vm.listDegrees.data).toEqual(response.data.data.length)

        //expect(wrapper.vm.$data.listDegrees.length = 2).toEqual(response.data.degree.length)
        //expect(wrapper.vm.$data.listDegrees.data.length).toEqual(response.data.data.length)
     }) 

     it("Calls axios and get create a degree", async () => {
        const response = await axios.get('/api/degree/create')
        expect(wrapper.vm.$data.degree.degree_name = 'Computer Science').toBe(response.data.degree[0].name)
        expect(wrapper.vm.$data.degree.degree_description = 'This is description for CS major').toBe(response.data.degree[0].description)
        expect(wrapper.vm.$data.degree.department_id = '1').toEqual(response.data.degree[0].department_id)
        expect(wrapper.vm.$data.degree.graduation_rate = 80).toEqual(response.data.degree[0].graduation_rate)
        expect(wrapper.vm.$data.degree.job_demand = 90).toEqual(response.data.degree[0].job_demand)
     }) 

 


})