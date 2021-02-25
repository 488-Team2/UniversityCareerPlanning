<template>
    <div>
        <h1>Salary</h1>
    
        <div>
            <select v-model="currentJob" name="jobSelect">
                <option value="0">Please select a job</option>
                <option v-for="job in jobArr" :value="job">{{ job }}</option>
             </select>
        </div>

        <div>
            <select v-model="currentState" name="stateSelect">
                <option value="0">Please select a State</option>
                <option v-for="state in stateArr" :value="state.state_name">{{ state.state_name}}</option>
             </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            currentJob: '',
            stateArr: [],
            currentState: ''
        }
    },
    props: {
        jobArr: {
            type: Array
        }

    },

    created() {
        this.fetchStates();
    },

    methods: {
        fetchStates() {

            fetch('/api/states')
                .then(res => res.json())
                .then(res => {
                    this.stateArr = res.data;
                })
                .catch(err => console.log(err));
        },
        calcSalary() {
            const URL = 'https://api.bls.gov/publicAPI/v2/timeseries/data/';
            const API_KEY = '?key=d99cc000b0ef4e9dac845bbb2fb0269d';
            const DATASET = 'OE';
            const NOT_SEASONAL = 'U';
            const STATE = 'S';
            const INDUSTRY_CODE = '000000';
            const AVERAGE_SALARY = '04';

            var stateCode = '5300000';
            var occupationalCode = '172071';

            var query = URL + DATASET + NOT_SEASONAL + STATE + stateCode + INDUSTRY_CODE + occupationalCode + AVERAGE_SALARY + API_KEY;
            var value;
            fetch(query)
                .then(res => res.json())
                .then(res => {
                    this.value = res.Results.series[0].data[0].value;
                })
                .catch(err => console.log(err));


        }
    },
    
}
</script>

<style>

</style>