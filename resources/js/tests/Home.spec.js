import { mount } from '@vue/test-utils'
import Navbar from '../components/Home.vue'

describe("Home", () => {
    test("If user is not logged in, do not show Load Saved Session button", () => {
      const wrapper = mount(Navbar);
      expect(wrapper.vm.currentUser).toBe(null);

    });

    test("If user logged in, show Load Saved Session button", () => {
        const wrapper = mount(Navbar);
        expect(wrapper.vm.currentUser !==  null).toBe(false);
      });

  });
  