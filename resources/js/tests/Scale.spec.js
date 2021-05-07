import {mount} from '@vue/test-utils'
import Scale from "../components/Scale.vue";
import axios from "axios"; 

test('required props', function() {
    expect(Scale.props.rate.required).toBe(true)
    expect(Scale.props.max.required).toBe(true)
    expect(Scale.props.min.required).toBe(true)
});

test('all props correct type', function() {
    expect(Scale.props.rate.type).toBe(Number)
    expect(Scale.props.name.type).toBe(String)
    expect(Scale.props.max.type).toBe(Number)
    expect(Scale.props.min.type).toBe(Number)
});

test('created method calculates range', function() {
    const wrapper = mount(Scale, {
        propsData: {
            rate: 3.4,
            name: "test",
            max: 10,
            min: -10 
        }
    })
    
    expect(wrapper.vm.range).toEqual(20);

});

test('calcRate method calculates margin-left with range starting at 0', function() {
    const wrapper = mount(Scale, {
        propsData: {
            rate: 32,
            name: "test",
            max: 100,
            min: 0 
        }
    })
    var res = wrapper.vm.$options.computed.calcRate.call(wrapper.vm);
    expect(res["margin-left"]).toEqual("32%");

});

test('calcRate method calculates margin-left with balanced range', function() {
    const wrapper = mount(Scale, {
        propsData: {
            rate: 4,
            name: "test",
            max: 10,
            min: -10 
        }
    })
    var res = wrapper.vm.$options.computed.calcRate.call(wrapper.vm);
    expect(res["margin-left"]).toEqual("70%");

});

test('calcRate method calculates margin-left with unbalanced range', function() {
    const wrapper = mount(Scale, {
        propsData: {
            rate: 14,
            name: "test",
            max: 30,
            min: -10 
        }
    })
    var res = wrapper.vm.$options.computed.calcRate.call(wrapper.vm);
    expect(res["margin-left"]).toEqual("60%");

});

test('calcRate method works with floating point numbers', function() {
    const wrapper = mount(Scale, {
        propsData: {
            rate: 4.5,
            name: "test",
            max: 10.9,
            min: -13.6 
        }
    })
    var res = wrapper.vm.$options.computed.calcRate.call(wrapper.vm);
    expect(res["margin-left"]).toEqual("73.87755102040816%");

});