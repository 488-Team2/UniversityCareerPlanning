import {mount} from '@vue/test-utils'
import Degrees from "../components/Degrees.vue";
import axios from "axios";
import Vue from "vue";

test('no prop url', function() {
    const wrapper = mount(Degrees);
    expect(wrapper.vm.url).toEqual('/api/degrees');
});

test('ids prop url', function(){

    const Constructor = Vue.extend(Degrees);
    const vm = new Constructor({
        propsData: {ids: "999 1004 1005 1006"}
    }).$mount();

    expect(vm.url).toEqual('/api/degrees/999 1004 1005 1006');
});

test('keywords prop url', function(){

    const Constructor = Vue.extend(Degrees);
    const vm = new Constructor({
        propsData: {keywords: "engineer"}
    }).$mount();

    expect(vm.url).toEqual('/api/search/engineer');
});

test('keywords and ids props expect keywords url', function(){

    const Constructor = Vue.extend(Degrees);
    const vm = new Constructor({
        propsData: {
            keywords: "engineer",
            ids: "999 1004 1005 1006"
        }
    }).$mount();

    expect(vm.url).toEqual('/api/search/engineer');
});


test('fetchDegrees', async() => {
    const wrapper = mount(Degrees);
    await wrapper.vm.fetchDegrees();

    const response = await axios.get('api/degrees');

    expect(wrapper.vm.degrees).toHaveLength(response.data.data.length);
    
});


test('correct Degrees', async()=>{
    const wrapper = mount(Degrees);
    await wrapper.vm.fetchDegrees();
    
    const response = await axios.get('api/degrees');

    expect(wrapper.vm.degrees[0]).toEqual(response.data.data[0])    
});
