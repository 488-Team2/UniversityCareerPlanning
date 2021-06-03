import { shallowMount } from '@vue/test-utils'
import Navbar from "../components/Navbar.vue"
import axios from "axios";
import flushPromises from 'flush-promises'

jest.mock('axios', () => {
    return {
      get:  jest.fn(() => Promise.resolve({ data: { id: 1, name: 'user 1' }}))
    }
})

describe("Navbar.vue", () => {
    let wrapper;
    beforeEach( async () => {
        wrapper = shallowMount(Navbar)
        jest.resetModules()
        jest.clearAllMocks()
      })

    it('initializes with correct elements', () => {
        // check the name of the component
        expect(wrapper.vm.$options.name).toMatch('navbar')

        // check that the heading text is rendered
        expect(wrapper.findAll('li').length).toEqual(8)
        expect(wrapper.findAll('li').at(0).text()).toMatch('Home')
        expect(wrapper.findAll('li').at(1).text()).toMatch('About')
        expect(wrapper.findAll('li').at(2).text()).toMatch('Contact Us')
        expect(wrapper.findAll('li').at(3).text()).toMatch('Degrees')
        expect(wrapper.findAll('li').at(4).text()).toMatch('Career Survey')

    })
    it("If user is not logged in, do not show logout button", () => {
      expect(wrapper.vm.currentUser).toBe(null);
    })

    it("If user logged in, show logout button", () => {
        expect(wrapper.vm.currentUser !==  null).toBe(false);
    })

    it("If loggedin user is admin, show admin dashboard", () => {
        expect(wrapper.vm.checkIsAdmin == false).toBe(false);
    })

    it("If loggedin user is student, show student dashboard", () => {
        expect(wrapper.vm.checkIsAdmin == true).toBe(false);
    })


    it("Calls axios.get and checks promise result", async () => {
       const response = await axios.get('/getCurrentUser');
        await flushPromises();
        expect(response).toEqual({ data: { id: 1, name: 'user 1'} });
        expect(wrapper.vm.currentUser = 'user 1').toBe(response.data.name)
        expect(axios.get).toBeCalledWith('/getCurrentUser');
    })

  });