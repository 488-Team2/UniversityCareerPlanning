import {mount} from '@vue/test-utils'
import Salary from "../components/Salary.vue";
import axios from "axios"; 
import fetch from 'cross-fetch'

test('Prop jobArr is of type Array and required is true', function() {
    expect(Salary.props.jobArr.required).toBe(true)
    expect(Salary.props.jobArr.type).toBe(Array)
});

test('fetchStates returns all states', async() => {
    const wrapper = mount(Salary, {
        propsData: {
            jobArr: ["Computer and Information Systems Managers","Database Administrators and Architects","Network and Computer Systems Administrators","Computer Network Architects"]
        }
    })
    await wrapper.vm.fetchStates();
    const response = await axios.get('/api/states');
    var stateArr = response.data.data;

    for(var i = 0; i < stateArr.length; i++){
        expect(wrapper.vm.stateArr[i]).toEqual(stateArr[i])
    }
});

test('currentJobName watch method', async() => {
    
    const wrapper = mount(Salary, {
        propsData: {
            jobArr: ["Computer and Information Systems Managers","Database Administrators and Architects","Network and Computer Systems Administrators","Computer Network Architects"]
        },
        data: () => ({ currentJobName: "Computer Network Architects" })
    })

    await wrapper.vm.$options.watch.currentJobName.call(wrapper.vm);

    try{
        const response = await axios.get('/api/job/' + "Computer Network Architects");
        var currentJobCode = response.data.data.job_code;
        var currentJobDemand = response.data.data.demand;
    } catch (error) {
        console.error(error);
    }

    expect(wrapper.vm.currentJobCode).toEqual(currentJobCode);
    expect(wrapper.vm.currentJobDemand).toEqual(currentJobDemand);

});

test('currentJobName watch method change salary change', async() => {
    
    const wrapper = mount(Salary, {
        propsData: {
            jobArr: ["Computer and Information Systems Managers","Database Administrators and Architects","Network and Computer Systems Administrators","Computer Network Architects"]
        },
        data: () => ({
            currentJobName: "Computer Network Architects",
            currentJobCode: "151241",
            currentState: {
                state_name: "Washington",
                state_code: "5300000",
            },
        })
    })

    await wrapper.vm.$options.watch.currentJobName.call(wrapper.vm);
    var originalSalary = wrapper.vm.salary;
    wrapper.vm.currentState.state_code = "5100000";
    wrapper.vm.currentState.state_name = "Virginia";
    await wrapper.vm.$options.watch.currentJobName.call(wrapper.vm);
    var newSalary = wrapper.vm.salary;

    expect(newSalary).not.toEqual(originalSalary);
    expect(newSalary).toEqual(132670);

});

test('currentJobName watch method call calcSalary call fetchStateJob', async() => {
    
    const wrapper = mount(Salary, {
        propsData: {
            jobArr: ["Computer and Information Systems Managers","Database Administrators and Architects","Network and Computer Systems Administrators","Computer Network Architects"]
        },
        data: () => ({
            currentJobName: "Computer Network Architects",
            currentJobCode: "151241",
            currentState: {
                state_name: "Washington",
                state_code: "5300000",
            },
        })
    })

    const calcSalary = jest.spyOn(wrapper.vm, 'calcSalary');
    const fetchStateJob = jest.spyOn(wrapper.vm, 'fetchStateJob');

    await wrapper.vm.$options.watch.currentJobName.call(wrapper.vm);
    var originalSalary = wrapper.vm.salary;
    wrapper.vm.currentState.state_code = "5100000";
    wrapper.vm.currentState.state_name = "Virginia";
    await wrapper.vm.$options.watch.currentJobName.call(wrapper.vm);
    var newSalary = wrapper.vm.salary;

    expect(calcSalary).toBeCalled();
    expect(fetchStateJob).toBeCalled();

});

test('calcSalary create query if stateJob combo not already stored in database', async() => {
    ``
    const wrapper = mount(Salary, {
        propsData: {
            jobArr: ["Computer and Information Systems Managers","Database Administrators and Architects","Network and Computer Systems Administrators","Computer Network Architects"]
        },
        data: () => ({
            currentJobName: "Software and Web Developers Programmers and Testers",
            currentJobCode: "151241",
            currentState: {
                state_name: "Washington",
                state_code: "5300000",
            },
        })
    })

    const storeStateJob = jest.spyOn(wrapper.vm, 'storeStateJob');

    await wrapper.vm.calcSalary();


    expect(storeStateJob).toBeCalled();

});
